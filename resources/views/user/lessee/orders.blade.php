@extends('user.base')
@section('section_title')
	<strong>Orders</strong>
@endsection

@section('section_body')

@if(count($orders) > 0)

<table class="table table-striped table-bordered table-responsive dataTable">
	<thead>
		<tr>
			<th>ID</th>
			<th>Total</th>
			<th>Date</th>
			<th>Actions</th>
		</tr>

	</thead>

	<tbody>
		@foreach( $orders as $order )
		<tr>
			<td>
				{!! $order->id !!}
			</td>

            <td>
				${!! $order->total !!}
            </td>

            <td>
				{{app('App\Helpers\DateTimeHelper')->ConvertIntoUTC($order->order_date)}}
			</td>

			<td>
				<div class="btn-group">
					<a class="btn btn-primary btn-xs" href="{{route('view.order',$order->id)}}">
                        <i class="fa fa-eye"></i>
				 	</a>
				</div>
			</td>
		</tr>
		@endforeach
	</tbody>
</table>

@else
	No Orders
@endif
@endsection