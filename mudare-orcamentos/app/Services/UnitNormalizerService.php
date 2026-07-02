<?php

namespace App\Services;

/**
 * Normaliza unidades de medida escritas de forma livre no memorial
 * para um conjunto canônico usado no orçamento.
 */
class UnitNormalizerService
{
    /**
     * Mapa de sinônimos => unidade canônica.
     */
    protected array $map = [
        'm2' => 'm²',
        'm²' => 'm²',
        'metro quadrado' => 'm²',
        'metros quadrados' => 'm²',
        'm3' => 'm³',
        'm³' => 'm³',
        'metro cubico' => 'm³',
        'metro cúbico' => 'm³',
        'm' => 'm',
        'ml' => 'm',
        'metro linear' => 'm',
        'metros lineares' => 'm',
        'un' => 'un',
        'und' => 'un',
        'unid' => 'un',
        'unidade' => 'un',
        'unidades' => 'un',
        'pç' => 'un',
        'pc' => 'un',
        'peca' => 'un',
        'peça' => 'un',
        'cj' => 'cj',
        'conjunto' => 'cj',
        'vb' => 'vb',
        'verba' => 'vb',
        'kg' => 'kg',
        'quilo' => 'kg',
        'ton' => 't',
        't' => 't',
        'l' => 'L',
        'litro' => 'L',
        'litros' => 'L',
        'gl' => 'gl',
        'galao' => 'gl',
        'galão' => 'gl',
        'pt' => 'pt',
        'ponto' => 'pt',
        'pontos' => 'pt',
        'h' => 'h',
        'hora' => 'h',
        'horas' => 'h',
        'dia' => 'dia',
        'mes' => 'mês',
        'mês' => 'mês',
    ];

    public function normalize(?string $unit): string
    {
        if ($unit === null) {
            return 'não identificado';
        }

        $clean = trim(mb_strtolower($unit));
        $clean = str_replace(['.', ' .', '. '], ['', '', ''], $clean);
        $clean = trim($clean);

        if ($clean === '' || $clean === 'nao identificado' || $clean === 'não identificado') {
            return 'não identificado';
        }

        return $this->map[$clean] ?? $unit;
    }

    /**
     * Retorna true se a unidade for reconhecida no conjunto canônico.
     */
    public function isKnown(?string $unit): bool
    {
        if ($unit === null) {
            return false;
        }

        $clean = trim(mb_strtolower($unit));

        return isset($this->map[$clean]);
    }
}
