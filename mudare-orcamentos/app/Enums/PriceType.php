<?php

namespace App\Enums;

enum PriceType: string
{
    case Referencial = 'referencial';
    case Cotado = 'cotado';
    case Historico = 'historico';
    case Estimado = 'estimado';

    public static function values(): array
    {
        return array_map(fn ($c) => $c->value, self::cases());
    }

    public function label(): string
    {
        return match ($this) {
            self::Referencial => 'Referencial',
            self::Cotado => 'Cotado',
            self::Historico => 'Histórico',
            self::Estimado => 'Estimado',
        };
    }
}
