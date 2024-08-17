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
               'success_url' => route('checkout.success', [], true) . '?session_id={CHECKOUT_SESSION_ID}',
                'cancel_url' => route('checkout.failure', [], true),
              ]);

        return redirect($session->url);
              
        }
    public function success(Request $request)
    {
        \Stripe\Stripe::setApiKey(getenv('STRIPE_SECRET_KEY'));

        try{
            $session = \Stripe\Checkout\Session::retrieve($request->get('session_id'));
            if(!$session){
                return view('checkout.failure');
            }
        
            $customer = \Stripe\Customer::retrieve($session->customer);

            return view('checkout.success', compact('customer'));

        }catch(\Exception $e){
       return view('checkout.failure');
        }
    
 
    }

    public function failure(Request $request)
    {
        dd($request->all());
    }
}
