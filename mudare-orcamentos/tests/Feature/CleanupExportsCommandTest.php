<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class CleanupExportsCommandTest extends TestCase
{
    use RefreshDatabase;

    public function test_command_removes_old_exports_and_keeps_recent(): void
    {
        $disk = Storage::fake('local');

        $disk->put('exports/old.csv', 'a;b');
        $disk->put('exports/new.csv', 'a;b');

        // Envelhece o arquivo "old" para 10 dias atrás.
        touch($disk->path('exports/old.csv'), now()->subDays(10)->getTimestamp());

        $this->artisan('exports:cleanup --days=7')->assertSuccessful();

        $this->assertFalse($disk->exists('exports/old.csv'));
        $this->assertTrue($disk->exists('exports/new.csv'));
    }

    public function test_dry_run_does_not_delete(): void
    {
        $disk = Storage::fake('local');
        $disk->put('exports/old.csv', 'a;b');
        touch($disk->path('exports/old.csv'), now()->subDays(30)->getTimestamp());

        $this->artisan('exports:cleanup --days=7 --dry-run')->assertSuccessful();

        $this->assertTrue($disk->exists('exports/old.csv'));
    }
}
