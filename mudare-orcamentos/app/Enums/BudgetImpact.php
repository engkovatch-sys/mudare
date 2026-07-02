<?php

namespace App\Enums;

enum BudgetImpact: string
{
    case Baixo = 'baixo';
    case Medio = 'medio';
    case Alto = 'alto';
    case MuitoAlto = 'muito_alto';
    case NaoIdentificado = 'nao_identificado';

    public static function values(): array
    {
        return array_map(fn ($c) => $c->value, self::cases());
    }

    public function label(): string
    {
        return match ($this) {
            self::Baixo => 'Baixo',
            self::Medio => 'Médio',
            self::Alto => 'Alto',
            self::MuitoAlto => 'Muito alto',
            self::NaoIdentificado => 'Não identificado',
        };
    }
}
