<?php

namespace App\Services;

/**
 * Consolida itens extraídos de múltiplos chunks: remove duplicatas óbvias
 * (mesmo item + ambiente + categoria), mantendo o de maior confiança.
 */
class ExtractionConsolidatorService
{
    /**
     * @param  array<int, array>  $items
     * @return array<int, array>
     */
    public function consolidate(array $items): array
    {
        $byKey = [];

        foreach ($items as $item) {
            if (! is_array($item)) {
                continue;
            }

            $key = $this->keyFor($item);
            $confidence = (int) ($item['confidence_score'] ?? 0);

            if (! isset($byKey[$key])) {
                $byKey[$key] = $item;
                continue;
            }

            $existingConfidence = (int) ($byKey[$key]['confidence_score'] ?? 0);

            // Mantém o item de maior confiança; agrega evidências textuais.
            if ($confidence > $existingConfidence) {
                $merged = $item;
                $merged['textual_evidence'] = $this->mergeEvidence($byKey[$key], $item);
                $byKey[$key] = $merged;
            } else {
                $byKey[$key]['textual_evidence'] = $this->mergeEvidence($byKey[$key], $item);
            }
        }

        return array_values($byKey);
    }

    protected function keyFor(array $item): string
    {
        $parts = [
            mb_strtolower(trim((string) ($item['item_identified'] ?? ''))),
            mb_strtolower(trim((string) ($item['environment'] ?? ''))),
            mb_strtolower(trim((string) ($item['category'] ?? ''))),
        ];

        return implode('|', $parts);
    }

    protected function mergeEvidence(array $a, array $b): string
    {
        $ea = trim((string) ($a['textual_evidence'] ?? ''));
        $eb = trim((string) ($b['textual_evidence'] ?? ''));

        $set = array_filter(array_unique([$ea, $eb]), fn ($v) => $v !== '' && $v !== 'não identificado');

        return implode(' | ', $set);
    }
}
