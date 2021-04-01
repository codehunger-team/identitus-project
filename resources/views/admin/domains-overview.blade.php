@extends('admin.base')

@section('section_title')
	<strong>Domains Overview</strong>
@endsection

@section('section_body')

<a class="btn btn-primary" href="/admin/add-domain">Add New Domain</a>
<hr />

@if($domains)
	<table class="table table-striped table-bordered table-responsive dataTable">
	<thead>
	<tr>
		<th>Domain</th>
		<th>Registrar</th>
		<th>Sale Price</th>
		<th>Discount Price</th>
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
				@if($d->registrar == $registrar->registrar_id)
					<td>
						{{ $registrar->registrar }}
					</td>
				@endif
			@endforeach
			
			<td>
				{{ App\Options::get_option( 'currency_symbol' ) . number_format($d->pricing, 0) }}

			</td>
			<td>
				{{ App\Options::get_option( 'currency_symbol' ) . number_format($d->discount) }}
			</td>
			<td>
				{{ $d->domain_status }}
			</td>
			<td>
				 <div class="btn-group">
						<a class="btn btn-success btn-xs" href="/admin/set-terms/{{$d->domain}}">
							{{ $d->domain_status != 'LEASE' ? 'Set Terms' : 'View Terms' }}
						</a>
					@if($d->domain_status != 'LEASE')
						<a class="btn btn-primary btn-xs" href="/admin/manage-domain/{!! $d->id !!}">
							<i class="glyphicon glyphicon-pencil"></i>
						</a>
						<a href="/admin/domains?remove={!! $d->id !!}" onclick="return confirm('Are you sure you want to remove this domain from database?');" class="btn btn-danger btn-xs">
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
@endif

@endsection