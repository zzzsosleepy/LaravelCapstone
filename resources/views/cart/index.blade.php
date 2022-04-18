@extends('common') 

@section('pagetitle')
Laravel Capstone - Cart
@endsection

@section('pagename')
Laravel Capstone
@endsection

@section('content')	

<div class="row center-content">
    <div class="col-md-8 text-center">
        <h1>Shopping Cart</h1>
    </div>
    <div class="col-md-2">
        <hr />
    </div>
</div>

<div class="row center-content">
    <div class="col-md-7">
        <table class="table">
            <thead>
                <th></th>
            </thead>
            <tbody>
                @php
                    $subTotal = 0;
                @endphp
                @foreach ($items as $item)
                    @php
                        $subTotal += $item->price * $item->quantity;
                    @endphp
                        <td class='shoppingCart'>
                            {{-- When you click on either the thumbnail or title, you will be brought to the details
                            page where you will display a larger picture plus all other fields that are required to be stored
                            (title, product_id, description, price, quantity, sku). --}}
                            <div class="text-center" style="margin-right: 15px;">
                                <h3>{{ $item->title }}</h3>
                            </div>
                            <div class="text-center">
                            @if ($item->picture != "")
                                <img src="{{ Storage::url('images/items/tn_'.$item->picture) }}" style='width:75px; height: 75px; object-fit:cover; border: 2px solid rgba(0,0,0,1); border-radius: 10px; box-shadow: 0px 5px 10px rgba(0,0,0,0.17);' >
                            @endif
                            <div style='font-size: 24px;'><strong>${{ $item->price }}</strong></div>
                            </div>
                            <div style='display: flex; flex-direction: column; margin-left: 15px;'>
                                <form action="{{ route('cart.update', $item->id) }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <input type="hidden" name="_method" value="PUT">
                                    <input type="text" name="quantity" value="{{ $item->quantity }}" style="width: 50px; text-align: center;">
                                    <input type="hidden" name="item_id" value="{{ $item->id }}">
                                    <button class="btn btn-success">Update</button>
                                </form>
                                <form style='display: flex; flex-direction: column;' action="{{ route('cart.destroy', $item->id) }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <input type="hidden" name="_method" value="DELETE">
                                    <button class="btn btn-danger" style="margin-top: 10px;">Remove</button>
                                </form>
                            </div>
                        </td>
                @endforeach
                <div>
                </div>
            </tbody>
        </table>
        <hr style='border: 1px solid rgba(0,0,0,0.2);'/>
        <div style='text-align: right;'>
            <h1>Subtotal: <strong>${{ $subTotal }}</strong></h1>
        </div>
        {{-- Customer information fields --}}
        <div>
            <h3>Customer Information</h3>
            {{-- When they click the submit order button at the bottom of
            the form, they will call the check_order route --}}
            <form action="{{ route('order.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label for="first_name">First Name</label>
                    <input type="text" name="first_name" class="form-control" id="first_name" placeholder="First Name">
                </div>
                <div class="form-group">
                    <label for="last_name">Last Name</label>
                    <input type="text" name="last_name" class="form-control" id="last_name" placeholder="Last Name">
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" name="email" class="form-control" id="email" placeholder="Email">
                </div>
                <div class="form-group">
                    <label for="phone">Phone</label>
                    <input type="text" name="phone" class="form-control" id="phone" placeholder="Phone">
                </div>
                {{-- Submit order button --}}
                <button type="submit" class="btn btn-primary">Submit Order</button>
            </form>
        </div>
    </div>
</div>

@endsection