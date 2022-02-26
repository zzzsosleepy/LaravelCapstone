<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Category;
use Session;
use Illuminate\Support\Facades\Auth;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Auth::check()) {
            $categories = Category::orderBy('name', 'ASC')->paginate(10);
            return view('categories.index')->with('categories', $categories);
        } else {
            return view('auth.login');
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (Auth::check()) {
            return view('categories.create');
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
            //validate the data
            // if fails, defaults to create() passing errors
            $this->validate($request, ['name' => 'required|max:100|unique:categories,name']);

            //send to DB (use ELOQUENT)
            $category = new Category;
            $category->name = $request->name;
            $category->save(); //saves to DB

            Session::flash('success', 'The category has been added');

            //redirect
            return redirect()->route('categories.index');
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
        //
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
            $category = Category::find($id);
            return view('categories.edit')->with('category', $category);
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
            $category = Category::find($id);
            $this->validate($request, ['name' => "required|max:100|unique:categories,name,$id"]);

            //send to DB (use ELOQUENT)
            $category->name = $request->name;

            $category->save(); //saves to DB

            Session::flash('success', 'The category has been updated');

            //redirect
            return redirect()->route('categories.index');
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
            $category = Category::find($id);
            $result = Category::find($id)->items;
            if ($result->isEmpty()) {
                $category->delete();
                Session::flash('success', 'The category has been deleted');
            }


            return redirect()->route('categories.index');
        } else {
            return view('auth.login');
        }
    }
}
