<?php

namespace App\Enums;



enum OrderStatus: string
{
    case Unpaid = 'Unpaid';
    case Paid = 'Paid';
    case Shipped = 'shipped';
    case Cancelled = 'cancelled';
    case Completed = 'completed';

    public static function getStatuses(){
        return [
            self::Paid,
            self::Unpaid,
            self::Cancelled,
            self::Shipped,
            self::Completed
        ];
    }
}

