<h1>
    Your order status was changed into {{$order->status}}
</h1>
<p>
Link to your order :
<a href="{{route('order.view', $order, true)}}">  
    Order #{{$order->id}}
</a>

</p>