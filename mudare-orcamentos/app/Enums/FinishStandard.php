<?php

namespace App\Enums;

enum FinishStandard: string
{
    case Comum = 'comum';
    case Especial = 'especial';
    case Luxo = 'luxo';
    case NaoIdentificado = 'nao_identificado';

    public static function values(): array
    {
        return array_map(fn ($c) => $c->value, self::cases());
    }

    public function label(): string
    {
        return match ($this) {
            self::Comum => 'Comum',
            self::Especial => 'Especial',
            self::Luxo => 'Luxo',
            self::NaoIdentificado => 'Não identificado',
        };
    }
}
