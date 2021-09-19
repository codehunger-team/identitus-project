@extends('user.base')

@section('section_title')
	<strong>Domains Overview</strong>
@endsection

@section('section_body')

<a class="btn btn-primary" href="{{route('add.domain')}}">Add New Domain</a>
</br>
</br>
</br>
Want us to help with bulk domains? Send us an email at <a href="mailto:info@identitius.com">info@identitius.com</a>.
</br>
</br>
<hr />

@isset($domains)
	<table class="table table-striped table-bordered table-responsive dataTable">
	<thead>
	<tr>
		<th>Domain</th>
		<th>Registrar</th>
		<th>Price</th>
		<th>Discount</th>
		<th>Status</th>
		<th>Actions</th>
	</tr>
	</thead>
	<tbody>
		@foreach( $domains as $d )
		<tr>
			<td>
				{{ $d->domain }}
			</td>
			@foreach($registrars as $registrar)
				@if($d->registrar_id == $registrar->id)
					<td>
						{{ $registrar->registrar }}
					</td>
				@endif
			@endforeach
			<td>
				{{ App\Models\Option::get_option( 'currency_symbol' ) . number_format($d->pricing, 0) }}

			</td>
			<td>
				{{ App\Models\Option::get_option( 'currency_symbol' ) . number_format($d->discount) }}
			</td>
			<td>
				{{ $d->domain_status }}
			</td>
			<td>
				 <div class="btn-group">					
				 	<a class="btn btn-success btn-xs mr-5" title="Set Terms" href="{{route('set.terms',$d->domain)}}">
						{{ $d->domain_status != 'LEASE' ? 'Set Terms' : 'View Terms' }}
					</a>
				@if($d->domain_status != 'LEASE')			
				 	<a class="btn btn-primary btn-xs mr-5" title="Edit Domain" href="{{route('manage.domain',$d->id)}}">
				 		<i class="fa fa-edit"></i>
				 	</a>
					<a href="{{route('domain.delete',$d->id)}}" title="Delete Domain" onclick="return confirm('Are you sure you want to remove this domain from database?');" class="btn btn-danger btn-xs mr-5">
						<i class="fa fa-trash text-white"></i>
					</a>
				 @endif
				 @php
					$counterOffer = app('App\Models\CounterOffer');
					$isInNegotitaion = $counterOffer::where('domain_name',$d->domain)->count()
				 @endphp
				 @if($isInNegotitaion > 0)
					<a class="btn btn-secondary btn-xs" title="Close Negotiation" onclick="return confirm('Are you sure you want to remove this domain negotiation from database?');" href="{{route('close.negotiation',$d->domain)}}">
						<i class="fa fa-times text-white"></i>
					</a>
				@endif
				</div>
			</td>
		</tr>
		@endforeach
	</tbody>
	</table>
@else
	No domains in database.
@endisset

@endsection