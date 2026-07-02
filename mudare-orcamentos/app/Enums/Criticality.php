<?php

namespace App\Enums;

enum Criticality: string
{
    case Baixa = 'baixa';
    case Media = 'media';
    case Alta = 'alta';
    case Critica = 'critica';
    case NaoIdentificado = 'nao_identificado';

    public static function values(): array
    {
        return array_map(fn ($c) => $c->value, self::cases());
    }

    public function label(): string
    {
        return match ($this) {
            self::Baixa => 'Baixa',
            self::Media => 'Média',
            self::Alta => 'Alta',
            self::Critica => 'Crítica',
            self::NaoIdentificado => 'Não identificado',
        };
    }
}
