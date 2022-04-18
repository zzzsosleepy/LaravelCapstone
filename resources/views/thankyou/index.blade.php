@extends('common') 

@section('pagetitle')
Laravel Capstone - Thank You
@endsection

@section('pagename')
Laravel Capstone
@endsection

@section('content')	
{{-- Add code to the top of the page that redirects you to the product page if the
session_id is not set. --}}
{{-- @php
	if(!isset($_SESSION['_token'])) {
		return redirect()->route('products.index');
	}
@endphp --}}

	<div class="row center-content">
		<div class="col-md-8 text-center">
			<h1>Thank You</h1>
		</div>
		<div class="col-md-2">
			<hr />
		</div>
	</div>
	<div class="row center-content">
		<div class="col-md-2">
			<table class="table text-right">
				<thead>
					<th class="text-right">Receipt</th>
				</thead>
				<tbody>
					{{-- Loop through the items and display each --}}
					@foreach ($items as $item)
						<tr>
							{{-- @php
							dd($item);
							@endphp --}}
							<td>{{ $item->title }} - <strong>${{ $item->price }}</strong> x {{ $item->quantity }} = <strong>${{ $item->price * $item->quantity }}</strong></td>

						</tr>
					@endforeach
					<tr>
						<td><strong>Total: ${{ $total }}</strong></td>
				</tbody>
			</table>
		</div>
	</div>

@endsection