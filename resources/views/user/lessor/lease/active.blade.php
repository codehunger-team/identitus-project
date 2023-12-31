@extends('user.base')

@section('section_title')
	<strong>Active Leases</strong>
@endsection

@section('section_body')

@if(isset($lease))
	<table class="table table-striped table-bordered table-responsive dataTable">
	<thead>
	<tr>
		<th>Domain</th>
		<th>Lessee Name</th>
		<th>Status</th>
		<th>Option Price</th>
		<th>Option Expiration</th>
		<th>First Payment</th>
        <th>Period Payment</th>
        <th>Period Type</th>
        <th>Number Of Periods</th>
        <th>Grace Period</th>
        <th>Start Date</th>
        <th>End Date</th>
        <th>Payment Due Date</th>
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
				{{ $d->name }}
			</td>
			<td>
				@if($d->contract_status_id == 1)
				 <button class="btn btn-success btn-xs">Paid</button>
				@else
				<button class="btn btn-danger btn-xs">Due</button>
				@endif
			</td>
			<td>
				@if(!empty($d->option_price))
				{{ App\Models\Option::get_option( 'currency_symbol' ) . number_format($d->option_price, 0) }}
				@else 
				{{ App\Models\Option::get_option( 'currency_symbol' ) . number_format(0, 0) }}
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
            @foreach($periodTypes as $periodValue)
                @if($periodValue->id == $d->period_type_id)
                    <td>
                        {{ $periodValue->period_type }}
                    </td>
                @endif
            @endforeach
            <td>
				{{ $d->number_of_periods }}
            </td>
			<td>5</td>
            {{-- @foreach($gracePeriod as $key => $gracePeriodValue)
                @if($gracePeriodValue->id == $d->grace_period_id)
                    <td>
                        {{ $gracePeriodValue->grace_period }}
                    </td>
                @else
                @endif
            @endforeach --}}
            <td>
				{{app('App\Helpers\DateTimeHelper')->ConvertIntoUTC($d->start_date)}} 
            </td>
            <td>
				{{app('App\Helpers\DateTimeHelper')->ConvertIntoUTC($d->end_date)}} 
            </td>
            <td>
				{{app('App\Helpers\DateTimeHelper')->ConvertIntoUTC($d->payment_due_date)}} 
            </td>
			<td>
				<div class="btn-group">																
					<a data-toggle="tooltip" title="View DNS" class="btn btn-primary btn-xs" href="{{route('view.dns',$d->id)}}">
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