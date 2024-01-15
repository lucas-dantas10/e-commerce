<?php declare(strict_types=1);

namespace App\Enums;

enum OrderStatus: string 
{
    case Unpaid = 'não pago';
    case Paid = 'pago';
    case Cancelled = 'cancelado';
    case Shipped = 'enviado';
    case Completed = 'completado';

    public static function getStatus(): array
    {
        return [
            self::Paid, self::Unpaid, self::Cancelled, self::Shipped, self::Completed,
        ];
    }
}
