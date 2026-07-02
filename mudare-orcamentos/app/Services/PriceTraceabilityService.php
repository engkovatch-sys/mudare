<?php

namespace App\Services;

use App\Models\Price;

/**
 * Garante rastreabilidade de preços. Nenhum preço pode ser tratado como
 * final sem os campos obrigatórios de origem e validação humana.
 */
class PriceTraceabilityService
{
    /**
     * Campos obrigatórios para um preço ser considerado rastreável.
     */
    protected array $requiredFields = [
        'supplier_id' => 'Fornecedor',
        'source' => 'Fonte',
        'collected_at' => 'Data de coleta',
        'unit' => 'Unidade',
    ];

    /**
     * Retorna a lista de problemas de rastreabilidade de um preço.
     *
     * @return array<int, string>
     */
    public function issues(Price $price): array
    {
        $issues = [];

        foreach ($this->requiredFields as $field => $label) {
            if (blank($price->{$field})) {
                $issues[] = "Campo obrigatório ausente: {$label}.";
            }
        }

        if ($price->price_type === 'estimado' && $price->validation_status !== 'approved') {
            $issues[] = 'Preço estimado não pode ser tratado como final sem validação humana.';
        }

        if ($price->valid_until && $price->valid_until->isPast()) {
            $issues[] = 'Preço com validade expirada.';
        }

        if (blank($price->validation_responsible)) {
            $issues[] = 'Sem responsável pela validação registrado.';
        }

        return $issues;
    }

    public function isTraceable(Price $price): bool
    {
        return empty($this->issues($price));
    }

    /**
     * Um preço só é "final" se rastreável, aprovado e não estimado
     * (ou estimado porém já aprovado por humano).
     */
    public function isFinal(Price $price): bool
    {
        return $this->isTraceable($price)
            && $price->validation_status === 'approved';
    }
}
