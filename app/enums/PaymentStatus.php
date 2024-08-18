<?php

namespace App\Enums;



enum PaymentStatus: string
{
    case Pending = 'pending';
    case Paid = 'Paid';
    case Failed = 'failed';
}

