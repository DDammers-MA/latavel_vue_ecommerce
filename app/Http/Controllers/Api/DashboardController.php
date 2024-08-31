<?php

namespace App\Http\Controllers\api;

use App\Enums\AddressType;
use App\Enums\CustomerStatus;
use App\Enums\OrderStatus;
use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function activeCustomers(){
    return Customer::where('status', CustomerStatus::Active->value)->count();
    }

    public function activeProducts(){
        return Product::count();
    }

    public function paidOrders(){
        return Order::where('status', OrderStatus::Paid->value)->count();
    }

    public function totalIncome(){
        return Order::where('status', OrderStatus::Paid->value)->sum('total_price');
    }

    public function ordersByCountry()
    {
        $orders = Order::query()
            ->select(['c.name', DB::raw('count(orders.id) as count')])
            ->join('users', 'created_by', '=', 'users.id')
            ->join('customer_addresses AS a', 'users.id', '=', 'a.customer_id')
            ->join('countries AS c', 'a.country_code', '=', 'c.code')
            ->where('status', OrderStatus::Paid->value)
            ->where('a.type', AddressType::Billing->value)
            ->groupBy('c.name')
            ->get();
    
        return $orders;
    }

    public function latesCustomer(){
        return Customer::query()
        ->select([ 'id', 'first_name', 'last_name', 'u.email', 'phone', 'u.created_at'])
            ->join('users as u', 'u.id', '=', 'customers.user_id')
            ->where('status', CustomerStatus::Active->value)
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();
    }
    
}
