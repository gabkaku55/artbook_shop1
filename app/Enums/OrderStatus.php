<?php

namespace App\Enums;

class OrderStatus
{
    public static function statusLabelByPayment(?string $paymentMethod): string
    {
        $pm = self::normalizePaymentMethod($paymentMethod);
        return match ($pm) {
            'card', 'online' => 'Оплачено',
            'cod' => 'Очікує',
            'bank' => 'В обробці',
            default => '—',
        };
    }

    public static function paymentLabel(?string $paymentMethod): string
    {
        $pm = self::normalizePaymentMethod($paymentMethod);
        return match ($pm) {
            'card', 'online' => 'Оплата картою',
            'cod' => 'Оплата при отриманні',
            'bank' => 'Квитанція',
            default => $pm ?: '—',
        };
    }

    public static function allowedStatusesByPayment(?string $paymentMethod): array
    {
        $pm = self::normalizePaymentMethod($paymentMethod);
        return match ($pm) {
            'card', 'online' => [
                'paid' => 'Оплачено',
                'processing' => 'Комплектація',
                'shipped' => 'Відправлено',
                'arrived' => 'Прибуло',
            ],
            'cod', 'bank' => [
                'pending' => 'Очікує',
                'confirmed' => 'Підтверджено',
                'processing' => 'Комплектація',
                'shipped' => 'Відправлено',
                'arrived' => 'Прибуло',
                'cancelled' => 'Скасовано',
            ],
            default => [],
        };
    }

    public static function normalizePaymentMethod(?string $paymentMethod): string
    {
        if ($paymentMethod === null || $paymentMethod === '') {
            return 'card';
        }
        return $paymentMethod === 'online' ? 'card' : $paymentMethod;
    }

    public static function isStatusAllowed(?string $paymentMethod, string $status): bool
    {
        $allowed = self::allowedStatusesByPayment($paymentMethod);
        return isset($allowed[$status]);
    }

    public static function resolveStatus(?string $paymentMethod, ?string $currentStatus): string
    {
        $allowed = self::allowedStatusesByPayment($paymentMethod);
        if ($currentStatus && isset($allowed[$currentStatus])) {
            return $currentStatus;
        }
        return array_key_first($allowed) ?? 'processing';
    }
}
