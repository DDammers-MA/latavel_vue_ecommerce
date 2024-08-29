<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Http\Request;
use Illuminate\Validation\UnauthorizedException;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        /** @var \App\Models\User $user */
        $user = $request->user();
    
        $orders = Order::query()
            ->where(['created_by' => $user->id])
            ->with('user.customer')
            ->orderBy('created_at', 'desc')
            ->paginate(10);
    
        return view('order.index', compact('orders'));
    }

    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    public function view(Order $order){

             /** @var \App\Models\User $user */
             $user = \request()->user();

             if($order->created_by !== $user->id ){
            return response("you don't have permission to view this order", 403);
             }

        return view('order.view', compact('order'));
    }
}
