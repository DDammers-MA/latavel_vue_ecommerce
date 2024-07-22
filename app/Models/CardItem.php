<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CardItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',     // Add user_id here
        'product_id',
        'quantity',
        // Include other attributes you want to be mass assignable
    ];
}
