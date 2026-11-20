<?php

namespace App\Enums;

enum UserRole: string
{
    case Admin = 'admin';
    case Cocina = 'cocina';

    public function label(): string
    {
        return match ($this) {
            self::Admin => 'Administrador',
            self::Cocina => 'Cocina',
        };
    }

    /**
     * @return array<int, string>
     */
    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
