<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Category;
use App\Item;
use Image;
use Storage;
// use Session;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class ListController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $ip = request()->ip();
        Session::put('ip', $ip);
        $items = Item::orderBy('title', 'ASC')->paginate(10);
        $categories = Category::all()->sortBy('name');
        return view('products.index')->with('items', $items)->with('categories', $categories);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (Auth::check()) {
            $categories = Category::all()->sortBy('name');
            return view('items.create')->with('categories', $categories);
        } else {
            return view('auth.login');
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (Auth::check()) {
            //dd(storage_path());;
            //validate the data
            // if fails, defaults to create() passing errors
            $this->validate($request, [
                'title' => 'required|string|max:255',
                'category_id' => 'required|integer|min:0',
                'description' => 'required|string',
                'price' => 'required|numeric',
                'quantity' => 'required|integer',
                'sku' => 'required|string|max:100',
                'picture' => 'required|image'
            ]);

            //send to DB (use ELOQUENT)
            $item = new Item;
            $item->title = $request->title;
            $item->category_id = $request->category_id;
            $item->description = strip_tags($request->description);
            $item->price = $request->price;
            $item->quantity = $request->quantity;
            $item->sku = $request->sku;

            //save image
            if ($request->hasFile('picture')) {
                $image = $request->file('picture');

                $filename = time() . '.' . $image->getClientOriginalExtension();
                $location = 'images/items/' . $filename;

                $image = Image::make($image);
                Storage::disk('public')->put($location, (string) $image->encode());
                $item->picture = $filename;
            }

            $item->save(); //saves to DB

            Session::flash('success', 'The item has been added');

            //redirect
            return redirect()->route('items.index');
        } else {
            return view('auth.login');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $ip = request()->ip();
        Session::put('ip', $ip);
        $items = Item::where('category_id', $id)->orderBy('title', 'ASC')->paginate(10);
        $categories = Category::all()->sortBy('name');
        return view('products.index')->with('items', $items)->with('categories', $categories);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (Auth::check()) {
            $item = Item::find($id);
            $categories = Category::all()->sortBy('name');
            return view('items.edit')->with('item', $item)->with('categories', $categories);
        } else {
            return view('auth.login');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if (Auth::check()) {
            //validate the data
            // if fails, defaults to create() passing errors
            $item = Item::find($id);
            $this->validate($request, [
                'title' => 'required|string|max:255',
                'category_id' => 'required|integer|min:0',
                'description' => 'required|string',
                'price' => 'required|numeric',
                'quantity' => 'required|integer',
                'sku' => 'required|string|max:100',
                'picture' => 'sometimes|image'
            ]);

            //send to DB (use ELOQUENT)
            $item->title = $request->title;
            $item->category_id = $request->category_id;
            $item->description = strip_tags($request->description);
            $item->price = $request->price;
            $item->quantity = $request->quantity;
            $item->sku = $request->sku;

            //save image
            if ($request->hasFile('picture')) {
                $image = $request->file('picture');

                $filename = time() . '.' . $image->getClientOriginalExtension();
                $location = 'images/items/' . $filename;

                $image = Image::make($image);
                Storage::disk('public')->put($location, (string) $image->encode());

                if (isset($item->picture)) {
                    $oldFilename = $item->picture;
                    Storage::delete('public/images/items/' . $oldFilename);
                }

                $item->picture = $filename;
            }

            $item->save(); //saves to DB

            Session::flash('success', 'The item has been updated');

            //redirect
            return redirect()->route('items.index');
        } else {
            return view('auth.login');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (Auth::check()) {
            $item = Item::find($id);
            if (isset($item->picture)) {
                $oldFilename = $item->picture;
                Storage::delete('public/images/items/' . $oldFilename);
            }
            $item->delete();

            Session::flash('success', 'The item has been deleted');

            return redirect()->route('items.index');
        } else {
            return view('auth.login');
        }
    }
}
