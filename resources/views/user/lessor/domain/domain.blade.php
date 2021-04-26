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
				 	<a class="btn btn-success btn-xs" href="{{route('set.terms',$d->domain)}}">
						{{ $d->domain_status != 'LEASE' ? 'Set Terms' : 'View Terms' }}
					</a>
				@if($d->domain_status != 'LEASE')			
				 	<a class="btn btn-primary btn-xs" href="{{route('manage.domain',$d->id)}}">
				 		<i class="glyphicon glyphicon-pencil"></i>
				 	</a>
					<a href="{{route('domain.delete',$d->id)}}" onclick="return confirm('Are you sure you want to remove this domain from database?');" class="btn btn-danger btn-xs">
						<i class="glyphicon glyphicon-remove"></i>
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