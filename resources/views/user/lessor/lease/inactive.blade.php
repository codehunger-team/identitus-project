@extends('user.base')

@section('section_title')
	<strong>Inactive Leases</strong>
@endsection

@section('section_body')

<!--<a class="btn btn-primary" href="{{route('add.domain')}}">Add New Contract</a>-->

Want us to help with adding or editing contracts in bulk? Send us an email at <a href="mailto:info@identitius.com">info@identitius.com</a>.
</br>
</br>
<hr />

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
				{{ App\Models\Option::get_option( 'currency_symbol' ) . number_format($d->option_price, 0) }}

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

            @foreach($gracePeriod as $key => $gracePeriodValue)
                @if($gracePeriodValue->id == $d->grace_period_id)
                    <td>
                        {{ $gracePeriodValue->grace_period }}
                    </td>
                @endif
            @endforeach
            <td>
                <div class="btn-group">
                <a class="btn btn-primary btn-xs" href="{{route('set.terms',$d->domain)}} ">
                    <i class="fa fa-edit" aria-hidden="true"></i>
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
