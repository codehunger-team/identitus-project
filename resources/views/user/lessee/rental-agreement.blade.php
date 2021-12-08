@extends('user.base')

@section('section_title')
	<strong>Agreements</strong>
@endsection

@section('section_body')

@if(isset($lease))
	<table class="table table-striped table-bordered table-responsive dataTable">
	<thead>
	<tr>
		<th>Domain</th>
		<th>Status</th>
		<th>Option Price</th>
		<th>Option Expiration</th>
		<th>First Payment</th>
        <th>Period Payment</th>
        <th>Lease End Date</th>
        <th>Next Payment</th>
        <th>Action</th>
	</tr>
	</thead>
	<tbody>
		@foreach( $lease as $d )
		<tr>
			<td>
				{{ $d->domain }}
			</td>
			<td>
				@if($d->contract_status_id == 1)
				 	<a href="#" class="btn btn-success btn-xs">Paid</a>
				@else
					<a href="{{url('user/lease-payment',$d->contract_id)}}" data-toggle="tooltip" title="Pay Dues" class="btn btn-danger btn-xs">Due</a>
				@endif
			</td>
			<td>
				@if(!empty($d->option_price))
				{{ App\Models\Option::get_option( 'currency_symbol' ) . number_format($d->option_price, 0) }}
				@else
				{{ App\Models\Option::get_option( 'currency_symbol' ) . 0}}
				@endif

            </td>
			@foreach($optionExpiration as $optionData)
                @if($optionData->id == $d->option_expiration)
                    <td>
                        {{ $optionData->option_expiration }}
                    </td>
				@endif
				@if($d->option_expiration == NULL)
                    <td>
                        Not Set
					</td>
					@break
                @endif
            @endforeach
            <td>
				{{ App\Models\Option::get_option( 'currency_symbol' ) . number_format($d->first_payment) }}
            </td>
            <td>
				{{ App\Models\Option::get_option( 'currency_symbol' ) . number_format($d->period_payment) }}
            </td>
            <td>
				{{app('App\Helpers\DateTimeHelper')->ConvertIntoUTC($d->end_date)}}
            </td>
            <td>
                {{app('App\Helpers\DateTimeHelper')->ConvertIntoUTC($d->payment_due_date)}}
            </td>
			<td>
				 <div class="btn-group">
				 	<a class="btn btn-danger btn-xs text-white mr-5" data-toggle="tooltip" title="Set DNS" href="{{route('user.add.dns',$d->id)}}">
						<i class="fa fa-edit" aria-hidden="true"></i>
					</a>
					<a class="btn btn-success text-white btn-xs" data-toggle="tooltip" title="View Terms" href="{{route('view.terms',$d->domain)}}">
						<i class="fa fa-eye" aria-hidden="true"></i>
					</a>
				</div>
			</td>
		</tr>
		@endforeach
	</tbody>
	</table>
@else
	No domains in database.
@endif

@endsection
