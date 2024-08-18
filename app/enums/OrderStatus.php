<?php

namespace App\Enums;



enum OrderStatus: string
{
    case Unpaind = 'Unpaid';
    case Paid = 'Paid';
    case Completed = 'completed';
}

