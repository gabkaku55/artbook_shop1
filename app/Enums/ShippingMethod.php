<?php

namespace App\Enums;

class ShippingMethod
{
    public static function label(?string $method): string
    {
        if ($method === null) {
            return '—';
        }

        $m = strtolower(trim($method));

        return match ($m) {
            'nova_poshta', 'nova poshta' => 'Нова пошта',
            'ukrposhta' => 'Укрпошта',
            'pickup' => 'Самовивіз',
            default => $method,
        };
    }
}

