@extends('common') 

@section('pagetitle')
Laravel Capstone - Products
@endsection

@section('pagename')
Laravel Capstone
@endsection

@section('content')	
	<div class="row">
		<div class="col-md-8 text-center">
			<h1>Product List</h1>
		</div>
		<div class="col-md-2">
			<hr />
		</div>
	</div>

	<div class="row">
		<div class="col-md-2" style='background-color: rgba(0,0,0,0.2); height: 100%; border-radius: 10px; width: 20%; margin-inline: auto;'>
			<table class="table text-center" >
				<thead>
					<th class="text-center" style='font-size: 24px; text-transform: uppercase;'>Category</th>
				</thead>
				<tbody>
					{{-- When a category link is followed, only
					products in that category are to be displayed --}}
					@foreach ($categories as $category)
						<tr>
							<td>
								<a style='text-transform: uppercase;' href="{{ route('products.show', $category->id) }}"><strong>{{ $category->name }}</strong></a>
							</td>
						</tr>
					@endforeach
				</tbody>
			</table>
		</div>

		<div class="col-md-7">
			<table class="table">
				<thead>
					<th></th>
				</thead>
				<tbody>
					@php
					$itemCount = 0;
					@endphp
					@foreach ($items as $item)
						@if ($itemCount == 0)
							<tr class='center-content row-2'>
						@endif
							<td class='center-content'>
								{{-- When you click on either the thumbnail or title, you will be brought to the details
								page where you will display a larger picture plus all other fields that are required to be stored
								(title, product_id, description, price, quantity, sku). --}}
								<a href="{{ route('items.show', $item->id) }}" style='text-align: center; font-size: 18px;'>{{ $item->title }}</a>
								@if ($item->picture != "")
									<a href="{{ route('items.show', $item->id) }}"><img src="{{ Storage::url('images/items/tn_'.$item->picture) }}" style='width:150px; height: 150px; object-fit:cover; border: 2px solid rgba(0,0,0,1); border-radius: 10px; box-shadow: 0px 5px 10px rgba(0,0,0,0.17);' ></a>
								@endif
								<div style='font-size: 32px;'><strong>${{ $item->price }}</strong></div>
								{{-- Add item to the cart when clicked --}}
								<form action="{{ route('cart.store') }}" method="POST" enctype="multipart/form-data">
									@csrf
									<input type="hidden" value="{{ $item->id }}" name="id">
									<button class="btn btn-success">Add to cart</button>
								</form>
							</td>
						@php
							$itemCount++;
						@endphp
						@if ($itemCount >= 2)
							</tr>
							@php
								$itemCount = 0;
							@endphp
						@endif
					@endforeach
				</tbody>
			</table>
		</div>
	</div>

@endsection