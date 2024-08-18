<?php

namespace App\Enums;



enum OrderStatus: string
{
    case Unpaid = 'Unpaid';
    case Paid = 'Paid';
    case Completed = 'completed';
}

