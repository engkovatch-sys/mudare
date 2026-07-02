<?php

namespace App\Enums;

enum ValidationStatus: string
{
    case Pending = 'pending';
    case Approved = 'approved';
    case Rejected = 'rejected';
    case NeedsRevision = 'needs_revision';

    public static function values(): array
    {
        return array_map(fn ($c) => $c->value, self::cases());
    }

    public function label(): string
    {
        return match ($this) {
            self::Pending => 'Pendente',
            self::Approved => 'Aprovado',
            self::Rejected => 'Rejeitado',
            self::NeedsRevision => 'Precisa revisão',
        };
    }

    public function badgeClass(): string
    {
        return match ($this) {
            self::Pending => 'bg-secondary',
            self::Approved => 'bg-success',
            self::Rejected => 'bg-danger',
            self::NeedsRevision => 'bg-warning text-dark',
        };
    }
}
