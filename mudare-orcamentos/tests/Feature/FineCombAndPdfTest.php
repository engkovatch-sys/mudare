<?php

namespace Tests\Feature;

use App\Models\ExtractedItem;
use App\Models\User;
use App\Models\Work;
use App\Services\BudgetFineCombService;
use App\Services\InternalPdfService;
use App\Services\ProposalPdfService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class FineCombAndPdfTest extends TestCase
{
    use RefreshDatabase;

    protected function makeWorkWithItem(): Work
    {
        $work = Work::create(['name' => 'Obra Malha', 'finish_standard' => 'luxo']);
        ExtractedItem::create([
            'work_id' => $work->id,
            'item_identified' => 'Item crítico de teste',
            'category' => 'Impermeabilização',
            'budget_impact' => 'alto',
            'criticality' => 'critica',
            'finish_standard' => 'luxo',
            'validation_status' => 'pending',
            'textual_evidence' => 'não identificado',
            'confidence_score' => 20,
        ]);

        return $work;
    }

    public function test_fine_comb_generates_alerts(): void
    {
        $work = $this->makeWorkWithItem();

        $service = app(BudgetFineCombService::class);
        $result = $service->run($work);

        $this->assertGreaterThan(0, $result['alerts_created']);
        // Item crítico pendente deve gerar alerta crítico.
        $this->assertDatabaseHas('budget_alerts', [
            'work_id' => $work->id,
            'severity' => 'critico',
        ]);
    }

    public function test_internal_pdf_is_generated(): void
    {
        $work = $this->makeWorkWithItem();
        app(BudgetFineCombService::class)->run($work);

        $proposal = app(InternalPdfService::class)->generate($work);

        $this->assertNotNull($proposal->file_path);
        $this->assertTrue(Storage::disk('local')->exists($proposal->file_path));
        $this->assertSame('internal', $proposal->proposal_type);
    }

    public function test_commercial_pdf_detects_critical_pending_items(): void
    {
        $work = $this->makeWorkWithItem();
        $service = app(ProposalPdfService::class);

        $this->assertTrue($service->criticalPendingItems($work)->isNotEmpty());
    }

    public function test_commercial_proposal_blocks_when_critical_pending(): void
    {
        $user = User::create(['name' => 'Admin', 'email' => 'a@b.com', 'password' => Hash::make('password')]);
        $this->actingAs($user);
        $work = $this->makeWorkWithItem();

        $this->post(route('works.proposals.commercial', $work))
            ->assertRedirect(route('works.proposals.index', $work))
            ->assertSessionHas('error');

        $this->assertDatabaseMissing('proposals', ['work_id' => $work->id, 'proposal_type' => 'commercial']);
    }
}
