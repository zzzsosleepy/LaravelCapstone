@extends('common') 

@section('pagetitle')
Item Details - {{ $item->title }}
@endsection

@section('pagename')
Laravel Capstone
@endsection

@section('content')

    <div class="row">
        <div class="col-md-8 col-md-offset-2 text-center">
            <div class="item-card">
                <h1>{{ $item->title }}</h1>
                <p>Product ID: {{ $item->id }}</p>
                <hr />
                @if ($item->picture != "")
                <img src="{{ Storage::url('images/items/lrg_'.$item->picture) }}" style='width:550px; height: 550px; object-fit:cover; border: 2px solid rgba(0,0,0,1); border-radius: 10px; box-shadow: 0px 5px 10px rgba(0,0,0,0.17);' >
                @endif
                <hr />
                <p style='font-size: 22px;'>Item Description: </p>
                <p style='font-size: 18px;'>{{ $item->description }}</p>
                <p style='font-size: 24px; font-weight: bold;'>${{ $item->price }}</p>
                <p>In stock: {{ $item->quantity }}</p>
                <p>SKU: {{ $item->sku }}</p>
            </div>
        </div>
    </div>

@endsection