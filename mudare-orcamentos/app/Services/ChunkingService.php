<?php

namespace App\Services;

/**
 * Divide textos longos de memorial em blocos (chunks) com sobreposição,
 * respeitando limites de tokens/caracteres da API e evitando cortar frases.
 */
class ChunkingService
{
    /**
     * @return array<int, string>
     */
    public function chunk(string $text, ?int $size = null, ?int $overlap = null): array
    {
        $size = $size ?? (int) config('anthropic.chunk_size', 12000);
        $overlap = $overlap ?? (int) config('anthropic.chunk_overlap', 500);

        $text = trim($text);

        if ($text === '') {
            return [];
        }

        if (mb_strlen($text) <= $size) {
            return [$text];
        }

        $chunks = [];
        $length = mb_strlen($text);
        $start = 0;

        while ($start < $length) {
            $end = min($start + $size, $length);
            $slice = mb_substr($text, $start, $end - $start);

            // Tenta terminar em uma quebra de parágrafo ou frase para não cortar contexto.
            if ($end < $length) {
                $breakPos = $this->lastBreak($slice);
                if ($breakPos !== null && $breakPos > (int) ($size * 0.5)) {
                    $slice = mb_substr($slice, 0, $breakPos);
                }
            }

            $chunks[] = trim($slice);

            $advance = max(1, mb_strlen($slice) - $overlap);
            $start += $advance;
        }

        return array_values(array_filter($chunks, fn ($c) => $c !== ''));
    }

    protected function lastBreak(string $slice): ?int
    {
        foreach (["\n\n", ". ", ".\n", "; ", "\n"] as $needle) {
            $pos = mb_strrpos($slice, $needle);
            if ($pos !== false) {
                return $pos + mb_strlen($needle);
            }
        }

        return null;
    }
}
