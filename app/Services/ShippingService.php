<?php

namespace App\Services;

class ShippingService
{
    public const FREE_DELIVERY_THRESHOLD = 1000;
    public const UKRPOSHTA_COST = 45;
    public const NOVA_POSHTA_COST = 119;

    public static function getCost(float $subtotal, string $shippingMethod): float
    {
        if ($subtotal >= self::FREE_DELIVERY_THRESHOLD) {
            return 0;
        }
        $m = strtolower(trim($shippingMethod));
        if ($m === 'ukrposhta') {
            return self::UKRPOSHTA_COST;
        }
        if (in_array($m, ['nova poshta', 'nova_poshta'], true)) {
            return self::NOVA_POSHTA_COST;
        }
        if ($m === 'pickup') {
            return 0;
        }
        return self::NOVA_POSHTA_COST;
    }

    public static function normalizeMethod(string $method): string
    {
        $m = strtolower(trim($method));
        if ($m === 'ukrposhta') {
            return 'ukrposhta';
        }
        if ($m === 'nova poshta' || $m === 'nova_poshta') {
            return 'nova_poshta';
        }
        return $method;
    }
}
