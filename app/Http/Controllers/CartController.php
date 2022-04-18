<?php

namespace App\Http\Controllers;

use App\Category;
use App\Item;
use App\ShoppingCart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class CartController extends Controller
{

    public function index()
    {
        $ip = request()->ip();
        Session::put('ip', $ip);
        //Retrieve all shopping carts from DB with the current IP and create an array of all items in each cart
        $carts = ShoppingCart::where('session_id', Session::get('_token'))->get();
        $items = [];
        foreach ($carts as $cart) {
            $newItem = Item::find($cart->item_id);
            $newItem->quantity = $cart->quantity;
            array_push($items, $newItem);
        }
        $categories = Category::all()->sortBy('name');
        return view('cart.index')->with('items', $items)->with('categories', $categories);
    }

    // When you press the “add to cart” button, you will insert the item_id, the session_id, IP
    // address, and quantity of 1 into a table called shopping_cart. You will then redirect to a
    // shopping cart page.
    public function store(Request $request)
    {
        $ip = request()->ip();
        Session::put('ip', $ip);
        if (ShoppingCart::where('session_id', Session::get('_token'))->where('item_id', $request->item_id)->exists()) {
            $cart = ShoppingCart::where('session_id', Session::get('_token'))->where('item_id', $request->item_id)->first();
            $cart->quantity += 1;
            $cart->save();
        } else {
            $cart = new ShoppingCart;
            $cart->item_id = $request->id;
            $cart->session_id = Session::get('_token');
            $cart->ip = $ip;
            $cart->quantity = 1;
            $cart->save();
        }
        return redirect()->route('cart.index')->with('cart', $cart);
    }
    //     When update is pressed, you
    // will call a route called update_cart. The quantity is updated in the assocsiated controller
    // method (do not exceed item quantity in the database),
    public function update(Request $request)
    {
        $cart = ShoppingCart::where('session_id', Session::get('_token'))->where('item_id', $request->item_id)->first();
        $cart->quantity = $request->quantity;
        $cart->save();
        print("LOL");
        return redirect()->route('cart.index')->with('cart', $cart);
    }

    public function show()
    {
        return redirect()->route('cart.index');
    }

    public function destroy($id)
    {
        $cart = ShoppingCart::where('session_id', Session::get('_token'))->where('item_id', $id)->first();
        $cart->delete();
        Session::flash('success', 'The item has been deleted');

        return redirect()->route('cart.index');
    }
}
