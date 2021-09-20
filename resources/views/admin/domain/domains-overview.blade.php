@extends('admin.base')
@section('section_title')
<div class="row">
	<div class="col-sm-6">
		<strong>Domains Overview</strong>
	</div>
	<div class="col-sm-6">
		<a class="btn btn-primary float-right" href="{{route('admin.add.domain')}}">Add New Domain</a>
	</div>
</div>
@endsection
@section('section_body')
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
                    <a class="btn btn-success mr-5 text-white" href="{{url('/admin/set-terms',$d->domain)}}">
                        {{ $d->domain_status != 'LEASE' ? 'Set Terms' : 'View Terms' }}
                    </a>
                    @if($d->domain_status != 'LEASE')
                    <a class="btn btn-primary mr-5 text-white" href="{{url('/admin/manage-domain',$d->id)}}">
                        <i class="fa fa-edit"></i>
                    </a>
                    <a href="{{url('admin/domains?remove=')}}{!! $d->id !!}"
                        onclick="return confirm('Are you sure you want to remove this domain from database?');"
                        class="btn btn-danger mr-5">
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
@endif
@endsection
