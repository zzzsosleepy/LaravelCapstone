@extends('common') 

@section('pagetitle')
Laravel Capstone - Orders
@endsection

@section('pagename')
Laravel Capstone
@endsection

@section('content')	
	<div class="row center-content">
		<div class="col-md-8 text-center">
			<h1>View Orders</h1>
		</div>
		<div class="col-md-2">
			<hr />
		</div>
	</div>
	<div class="row center-content">
		<div class="col-md-2">
			<table class="table text-right">
				<thead>
					<th class="text-right">Completed Orders</th>
				</thead>
				<tbody>
					{{-- Loop through the items and display each --}}
					@foreach ($orders as $order)
						<tr>
							<td>{{ $order->id }} - {{ $order->first_name}} {{ $order->last_name }} - {{ $order->phone }} - {{ $order->email }} - Session: {{ $order->session_id }}</td>
                            {{-- View order button --}}
                            <td><a href="{{ route('order.show', $order->id) }}" class="btn btn-primary">View Order</a></td>
						</tr>
					@endforeach
				</tbody>
			</table>
		</div>
	</div>

@endsection