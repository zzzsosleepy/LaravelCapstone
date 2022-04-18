<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Order;
use App\Item;
use App\ShoppingCart;
use App\ItemSold;
use Illuminate\Support\Facades\Session;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::all();
        return view('orders.index')->with('orders', $orders);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email',
            'phone' => 'required|string',
        ]);

        $order = new Order();
        $order->first_name = $request->input('first_name');
        $order->last_name = $request->input('last_name');
        $order->email = $request->input('email');
        $order->phone = $request->input('phone');
        $order->ip = $request->ip();
        $order->session_id = Session::get('_token');
        $order->save();
        $order_id = $order->id;
        //Loop through the cart and move each item into a table called items_sold which contains the
        //item_id, order_id, item_price, and quantity.
        $carts = ShoppingCart::where('session_id', Session::get('_token'))->get();
        foreach ($carts as $cart) {
            $item = new ItemSold();
            $item->item_id = $cart->item_id;
            $item->order_id = $order_id;
            $item->price = Item::find($cart->item_id)->price;
            $item->quantity = $cart->quantity;
            $item->save();
        }


        return redirect()->route('thankyou.index');
    }

    public function show($id)
    {
        $order = Order::find($id);
        $items = ItemSold::where('order_id', $id)->get();
        $total = 0;
        foreach ($items as $item) {
            $total += $item->price * $item->quantity;
            $item->title = Item::find($item->item_id)->title;
        }
        return view('orders.show')->with('order', $order)->with('items', $items)->with('total', $total);
    }
}
