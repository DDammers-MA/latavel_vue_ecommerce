<?php

namespace App\Http\Controllers;

use App\Helpers\Cart;
use Illuminate\Http\Request;

class checkoutController extends Controller
{

    public function checkout(Request $request)
        {
            \Stripe\Stripe::setApiKey(getenv('STRIPE_SECRET_KEY'));

        list($products, $cartItems) = Cart::getProductsAndCartItems();
     
        $lineItems = [];
        foreach ($products as $product){
            $lineItems[] = [
                'price_data' => [
                    'currency' => 'usd',
                    'product_data' => [
                      'name' => $product->title,
                      'images'=> [$product->image],
                    ],
                    'unit_amount' => $product->price * 100,
                  ],
                  'quantity' => $cartItems[$product->id]['quantity'],
            ];
        }


            $session = \Stripe\Checkout\Session::create([
                'line_items' => $lineItems,
                'mode' => 'payment',
                'success_url' => route('checkout.success', [], true),
                'cancel_url' => route('checkout.failure', [], true),
              ]);

        return redirect($session->url);
              
        }
    public function success(Request $request)
    {
        dd($request->all());
    }

    public function failure(Request $request)
    {
        dd($request->all());
    }
}
