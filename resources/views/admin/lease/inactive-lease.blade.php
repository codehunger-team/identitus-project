@extends('admin.base')

@section('section_title')
	<strong>Inactive Lease</strong>
@endsection

@section('section_body')

@if(isset($lease))
	<table class="table table-striped table-bordered table-responsive dataTable">
	<thead>
	<tr>
		<th>Domain</th>
		<th>Sale Price</th>
        <th>Option Price</th>
		<th>Lease Total</th>
		<th>Option Expiration</th>
		<th>First Payment</th>
        <th>Period Payment</th>
        <th>Period Type</th>
        <th>Number Of Periods</th>
        <th>Grace Period</th>
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
				{{ App\Models\Option::get_option( 'currency_symbol' ) . number_format($d->pricing, 0) }}
            </td>
            
			<td>
                @if (!empty($d->option_price))
                {{ App\Models\Option::get_option( 'currency_symbol' ) . number_format($d->option_price, 0) }}
                @else
                {{ App\Models\Option::get_option( 'currency_symbol' ) . 0 }}
                @endif

            </td>
            <td>
				{{ App\Models\Option::get_option( 'currency_symbol' ) . number_format($d->lease_total, 0) }}

            </td>
            
			@foreach($optionExpiration as $optionData)
                @if($optionData->id == $d->option_expiration)
                    <td>
                        {{ $optionData->option_expiration }}
                    </td>
                @elseif ($d->option_expiration == NULL)
                    <td>
                        {{ $optionData->option_expiration }}
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
                <div class="btn-group">                     
                    <a class="btn btn-primary btn-xs" href="{{url('/admin/set-terms',$d->domain)}}">
                        <i class="fa fa-edit"></i>
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