<?php

namespace Tests\Feature;

use App\Models\ExtractedItem;
use App\Models\Work;
use App\Services\CsvExportService;
use App\Services\WebhookDispatchService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class SecurityAndExportTest extends TestCase
{
    use RefreshDatabase;

    public function test_csv_export_neutralizes_formula_injection(): void
    {
        $work = Work::create(['name' => 'Obra CSV', 'finish_standard' => 'luxo']);
        ExtractedItem::create([
            'work_id' => $work->id,
            'item_identified' => '=HYPERLINK("http://evil","x")',
            'category' => '+SUM(A1:A2)',
            'budget_impact' => 'alto',
            'criticality' => 'alta',
            'finish_standard' => 'luxo',
            'validation_status' => 'pending',
        ]);

        $path = app(CsvExportService::class)->export($work, 'items');
        $csv = Storage::disk('local')->get($path);

        // Valores com caractere de fórmula devem ser prefixados com apóstrofo.
        $this->assertStringContainsString("'=HYPERLINK", $csv);
        $this->assertStringContainsString("'+SUM(A1:A2)", $csv);
        // Não deve existir uma célula iniciando a fórmula sem escape.
        $this->assertStringNotContainsString(';=HYPERLINK', $csv);
    }

    public function test_webhook_blocks_loopback_url(): void
    {
        Http::fake();
        $work = Work::create(['name' => 'Obra WH', 'finish_standard' => 'luxo']);

        $log = app(WebhookDispatchService::class)->dispatchForWork($work, 'http://127.0.0.1/webhook');

        $this->assertSame(0, $log->response_status);
        $this->assertStringContainsString('bloqueado', $log->response_body);
        Http::assertNothingSent();
    }

    public function test_webhook_blocks_private_range_url(): void
    {
        Http::fake();
        $work = Work::create(['name' => 'Obra WH2', 'finish_standard' => 'luxo']);

        $log = app(WebhookDispatchService::class)->dispatchForWork($work, 'http://10.0.0.5/hook');

        $this->assertSame(0, $log->response_status);
        $this->assertStringContainsString('bloqueado', $log->response_body);
        Http::assertNothingSent();
    }

    public function test_webhook_rejects_non_http_scheme(): void
    {
        Http::fake();
        $work = Work::create(['name' => 'Obra WH3', 'finish_standard' => 'luxo']);

        $log = app(WebhookDispatchService::class)->dispatchForWork($work, 'file:///etc/passwd');

        $this->assertSame(0, $log->response_status);
        $this->assertStringContainsString('bloqueado', $log->response_body);
        Http::assertNothingSent();
    }

    public function test_webhook_allows_public_url(): void
    {
        Http::fake([
            '*' => Http::response('ok', 200),
        ]);
        $work = Work::create(['name' => 'Obra WH4', 'finish_standard' => 'luxo']);

        // IP público literal evita dependência de DNS no teste.
        $log = app(WebhookDispatchService::class)->dispatchForWork($work, 'https://8.8.8.8/hook');

        $this->assertSame(200, $log->response_status);
        Http::assertSent(fn ($request) => $request->url() === 'https://8.8.8.8/hook');
    }
}
