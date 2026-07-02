<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

/**
 * Remove arquivos CSV antigos de storage/app/exports para evitar crescimento
 * indefinido do disco em hospedagem compartilhada.
 *
 * Só apaga a pasta de EXPORTS (arquivos efêmeros de download). NÃO toca em
 * storage/app/proposals, pois os PDFs de propostas são referenciados por
 * registros na tabela `proposals` e permanecem disponíveis para download.
 */
class CleanupExportsCommand extends Command
{
    protected $signature = 'exports:cleanup {--days=7 : Idade mínima (em dias) para remover} {--dry-run : Apenas lista o que seria removido}';

    protected $description = 'Remove exports CSV antigos de storage/app/exports';

    public function handle(): int
    {
        $days = max(0, (int) $this->option('days'));
        $dryRun = (bool) $this->option('dry-run');
        $cutoff = now()->subDays($days)->getTimestamp();

        $disk = Storage::disk('local');

        if (! $disk->exists('exports')) {
            $this->info('Nada a limpar: a pasta exports não existe.');

            return self::SUCCESS;
        }

        $deleted = 0;
        $kept = 0;

        foreach ($disk->files('exports') as $path) {
            // Preserva o .gitignore/.gitkeep e quaisquer arquivos ocultos.
            if (str_starts_with(basename($path), '.')) {
                continue;
            }

            if ($disk->lastModified($path) <= $cutoff) {
                if ($dryRun) {
                    $this->line("[dry-run] removeria: {$path}");
                } else {
                    $disk->delete($path);
                }
                $deleted++;
            } else {
                $kept++;
            }
        }

        $verb = $dryRun ? 'seriam removidos' : 'removidos';
        $this->info("Exports: {$deleted} arquivo(s) {$verb} (mais de {$days} dia(s)); {$kept} mantido(s).");

        return self::SUCCESS;
    }
}
