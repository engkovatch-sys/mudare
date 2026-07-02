<?php

namespace Tests\Feature;

use App\Models\ExtractedItem;
use App\Models\User;
use App\Models\Work;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class WorkFlowTest extends TestCase
{
    use RefreshDatabase;

    protected function admin(): User
    {
        return User::create([
            'name' => 'Admin',
            'email' => 'admin@exemplo.com',
            'password' => Hash::make('password'),
        ]);
    }

    public function test_authenticated_user_can_create_work(): void
    {
        $this->actingAs($this->admin());

        $response = $this->post(route('works.store'), [
            'name' => 'Residência Alpha',
            'finish_standard' => 'luxo',
            'status' => 'rascunho',
        ]);

        $this->assertDatabaseHas('works', ['name' => 'Residência Alpha', 'finish_standard' => 'luxo']);
        $work = Work::first();
        $response->assertRedirect(route('works.show', $work));
    }

    public function test_can_create_memorial_with_manual_text(): void
    {
        $this->actingAs($this->admin());
        $work = Work::create(['name' => 'Obra X', 'finish_standard' => 'luxo']);

        $this->post(route('memorials.store', $work), [
            'manual_text' => 'Impermeabilização de piscina em manta asfáltica. Esquadrias minimalistas de alumínio.',
        ])->assertRedirect();

        $this->assertDatabaseHas('memorials', [
            'work_id' => $work->id,
            'extraction_mode' => 'manual_text',
            'processing_status' => 'pending',
        ]);
    }

    public function test_memorial_requires_pdf_or_manual_text(): void
    {
        $this->actingAs($this->admin());
        $work = Work::create(['name' => 'Obra Y', 'finish_standard' => 'luxo']);

        $this->post(route('memorials.store', $work), [])
            ->assertSessionHasErrors('manual_text');
    }

    public function test_process_returns_friendly_message_when_api_not_configured(): void
    {
        config(['anthropic.api_key' => '']);
        $this->actingAs($this->admin());
        $work = Work::create(['name' => 'Obra Z', 'finish_standard' => 'luxo']);
        $memorial = $work->memorials()->create([
            'manual_text' => 'Texto do memorial de teste.',
            'extraction_mode' => 'manual_text',
            'processing_status' => 'pending',
        ]);

        $this->post(route('memorials.process', $memorial))
            ->assertRedirect(route('memorials.show', $memorial))
            ->assertSessionHas('error', 'API Anthropic não configurada. Verifique o arquivo .env.');

        $this->assertDatabaseHas('memorials', ['id' => $memorial->id, 'processing_status' => 'failed']);
    }

    public function test_extracted_item_validation_records_validator(): void
    {
        $this->actingAs($this->admin());
        $work = Work::create(['name' => 'Obra W', 'finish_standard' => 'luxo']);
        $item = ExtractedItem::create([
            'work_id' => $work->id,
            'item_identified' => 'Esquadria minimalista',
            'budget_impact' => 'alto',
            'criticality' => 'alta',
            'finish_standard' => 'luxo',
            'validation_status' => 'pending',
        ]);

        $this->put(route('extracted-items.update', $item), [
            'item_identified' => 'Esquadria minimalista',
            'budget_impact' => 'alto',
            'criticality' => 'alta',
            'finish_standard' => 'luxo',
            'validation_status' => 'approved',
        ])->assertRedirect();

        $item->refresh();
        $this->assertSame('approved', $item->validation_status);
        $this->assertNotNull($item->validated_at);
        $this->assertSame('Admin', $item->validated_by);
    }
}
