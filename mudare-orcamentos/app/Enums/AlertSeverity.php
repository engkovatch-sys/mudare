<?php

namespace App\Enums;

enum AlertSeverity: string
{
    case Informativo = 'informativo';
    case Baixo = 'baixo';
    case Medio = 'medio';
    case Alto = 'alto';
    case Critico = 'critico';

    public static function values(): array
    {
        return array_map(fn ($c) => $c->value, self::cases());
    }

    public function label(): string
    {
        return match ($this) {
            self::Informativo => 'Informativo',
            self::Baixo => 'Baixo',
            self::Medio => 'Médio',
            self::Alto => 'Alto',
            self::Critico => 'Crítico',
        };
    }

    public function badgeClass(): string
    {
        return match ($this) {
            self::Informativo => 'bg-info text-dark',
            self::Baixo => 'bg-secondary',
            self::Medio => 'bg-primary',
            self::Alto => 'bg-warning text-dark',
            self::Critico => 'bg-danger',
        };
    }
}
