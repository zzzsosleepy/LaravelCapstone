<?php

namespace App\Http\Controllers;

use App\ItemSold;
use App\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class ThankyouController extends Controller
{
    public function index()
    {
        // display a receipt for the order (list of items ordered, cost of order, customer details)
        // by retrieving the session_id and IP from the browser

        // get all item from the items_sold table
        $itemsSold = ItemSold::all();
        $items = [];
        foreach ($itemsSold as $item) {
            $newItem = Item::find($item->item_id);
            $newItem->quantity = $item->quantity;
            array_push($items, $newItem);
        }
        $total = 0;
        foreach ($items as $item) {
            $total += $item->price * $item->quantity;
        }
        Session::forget('_token');

        return view('thankyou.index')->with('items', $items)->with('total', $total);
    }
}
