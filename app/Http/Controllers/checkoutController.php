<?php

namespace App\Http\Controllers;

use App\Enums\OrderStatus;
use App\Enums\PaymentStatus;
use App\Helpers\Cart;
use App\Models\CardItem;
use App\Models\Customer;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Payment;
use Illuminate\Http\Request;

class CheckoutController extends Controller
{

    public function checkout(Request $request)
        {

        /** @var \App\Models\User $user */
        $user = $request->user();

        \Stripe\Stripe::setApiKey(getenv('STRIPE_SECRET_KEY'));
            

        [$products, $cartItems] = Cart::getProductsAndCartItems();
        $orderItems = [];
        $lineItems = [];
        $totalPrice = 0;
        foreach ($products as $product){
            $quantity =  $cartItems[$product->id]['quantity'];
            $totalPrice += $product->price * $quantity;
        
            $lineItems[] = [
                'price_data' => [
                    'currency' => 'usd',
                    'product_data' => [
                      'name' => $product->title,
                      'images'=> [$product->image],
                    ],
                    'unit_amount' => $product->price * 100,
                  ],
                  'quantity' => $quantity,
            ];

            $orderItems[] = [
                'product_id' => $product->id,
                'quantity' => $quantity,
                'unit_price' => $product->price
            ];
        }

        $customer = \Stripe\Customer::create([
            'name' => $user->name,
            'email' => $user->email,


          ]);

          $request->session()->put('stripe_customer_id', $customer->id);



            $session = \Stripe\Checkout\Session::create([
                'line_items' => $lineItems,
                'mode' => 'payment',
                'customer' => $customer,
                'success_url' => route('checkout.success', [], true) . '?session_id={CHECKOUT_SESSION_ID}',
                'cancel_url' => route('checkout.failure', [], true),
              ]);

          

        $orderData = [
            'total_price' => $totalPrice,
            'status'=> OrderStatus::Unpaid,
            'created_by' => $user->id, 
            'updated_by' => $user->id,
        ];

        $order = Order::create($orderData);

        foreach ($orderItems as $orderItem) {
            $orderItem['order_id'] = $order->id;
            OrderItem::create($orderItem);
        }

        $paymentData = [
            'order_id' => $order->id,
            'amount' => $totalPrice,
            'status'=> PaymentStatus::Pending,
            'type'=> 'cc',
            'created_by' => $user->id,
            'updated_by' => $user->id,
            'session_id' => $session->id  
        ];

     Payment::create($paymentData);
     
   

        return redirect($session->url);
              
        }



    public function success(Request $request)
    {
                         /** @var \App\Models\User $user */
                         $user = $request->user();
        \Stripe\Stripe::setApiKey(getenv('STRIPE_SECRET_KEY'));

        try{
            $session_id = $request->get('session_id');
            $session = \Stripe\Checkout\Session::retrieve($session_id);
           if (!$session) {
                return view('checkout.failure', ['message' => 'Invalid Session ID']);
            }
        
            $payment = Payment::query()
            ->where(['session_id' => $session->id, 'status' => PaymentStatus::Pending])
            ->first();
      

            if(!$payment){
                return view('checkout.failure', ['message' => 'Payment does not exist']);
            }
            
            $payment->status = PaymentStatus::Paid;
            $payment->update();

            $order = $payment->order;


            $order->status = OrderStatus::Paid;
            $order->update();

            CardItem::where(['user_id' => $user->id])->delete();

            $customer = \Stripe\Customer::retrieve($session->customer);
  

            return view('checkout.success', compact('customer'));

        }catch(\Exception $e){
   

       return view('checkout.failure', ['message'=>$e->getMessage()]);
        }
    
 
    }

    public function failure(Request $request)
    {
        return view('checkout.failure', ['message'=> ""]);
    }

    public function checkoutOrder( Order $order, Request $request)
    {
  
      /** @var \App\Models\User $user */
      $user = $request->user();

      \Stripe\Stripe::setApiKey(getenv('STRIPE_SECRET_KEY'));

      $lineItems = [];

      foreach ($order->items as $item) {
     
          $lineItems[] = [
              'price_data' => [
                  'currency' => 'usd',
                  'product_data' => [
                      'name' => $item->product->title,
//                        'images' => [$product->image]
                  ],
                  'unit_amount' => $item->unit_price * 100,
              ],
              'quantity' => $item->quantity,
          ];
      }
      // Assuming Order has a relationship with Customer and Customer model has stripe_customer_id
      $stripeCustomerId = $request->session()->get('stripe_customer_id');

 
      $session = \Stripe\Checkout\Session::create([
        'line_items' => $lineItems,
        'mode' => 'payment',
        'customer' => $stripeCustomerId,
        'success_url' => route('checkout.success', [], true) . '?session_id={CHECKOUT_SESSION_ID}',
        'cancel_url' => route('checkout.failure', [], true),
      ]);

      $order->payment->session_id = $session->id;
      $order->payment->save();

      return redirect($session->url);
  
    }
}