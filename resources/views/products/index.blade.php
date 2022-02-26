@extends('common') 

@section('pagetitle')
Product List
@endsection

@section('pagename')
Laravel Project
@endsection

@section('content')
	
	<div class="row">
		<div class="col-md-8 col-md-offset-2">
			<h1>Product List</h1>
		</div>
		{{-- <div class="col-md-2">
			<a href="{{ route('items.create') }}" class="btn btn-lg btn-block btn-primary btn-h1-spacing">Create New Item</a>
		</div> --}}
		<div class="col-md-2">
			<hr />
		</div>
	</div>

	<div class="row">
		<div class="col-md-2">
			<table class="table">
				<thead>
					<th>Category</th>
				</thead>
				<tbody>
					@foreach ($categories as $category)
						<tr>
							<td>{{ $category->name }}</td>
						</tr>
					@endforeach
				</tbody>
			</table>
			<div class="text-center">
				{!! $items->links(); !!}
			</div>
		</div>

		<div class="col-md-7">
			<table class="table">
				<thead>
					<th></th>
				</thead>
				<tbody>
					@foreach ($items as $item)
						<tr>
							<td>{{ $item->title }}</td>
							@if ($item->picture != "")
								<td><img src="{{ Storage::url('images/items/'.$item->picture) }}" style='height:100px;' ></td>
							@endif
						</tr>
					@endforeach
				</tbody>
			</table>
			<div class="text-center">
				{!! $items->links(); !!}
			</div>
		</div>
	</div>

@endsection