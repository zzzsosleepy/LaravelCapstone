@extends('common') 

@section('pagetitle')
Laravel Capstone - Order {{ $order->id }}
@endsection

@section('pagename')
Laravel Capstone
@endsection

@section('content')	
	<div class="row center-content">
		<div class="col-md-8 text-center">
			<h1>View Order {{ $order->id }}</h1>
		</div>
		<div class="col-md-2">
			<hr />
		</div>
	</div>
	<div class="row center-content">
		<div class="col-md-2">
			<table class="table text-right">
				<thead>
					<th class="text-right">Order</th>
				</thead>
				<tbody>
                    {{-- Loop through the items and display each --}}
                    @foreach ($items as $item)
                    <tr>
                        <td>{{ $item->title }} - <strong>${{ $item->price }}</strong> x {{ $item->quantity }} = <strong>${{ $item->price * $item->quantity }}</strong></td>
                    </tr>
                    @endforeach
                    <tr>
                        <td><strong>Total: ${{ $total }}</strong></td>
                    </tr>
				</tbody>
			</table>
		</div>
	</div>

@endsection