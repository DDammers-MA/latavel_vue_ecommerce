<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index(Request $request)
    {
           /** @var \App\Models\User $user */
           $user = $request->user();

        $orders = Order::query()->where(['created_by' => $user->id])->paginate(200);

        return view('order.index', compact('orders'));
    }

    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }
}
