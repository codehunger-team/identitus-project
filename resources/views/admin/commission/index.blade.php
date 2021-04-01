@extends('admin.base')

@section('section_title')
	<strong>Seller List</strong>
@endsection

@section('section_body')
<a class="btn btn-primary" href="/admin/add-domain">Set Commission Rule</a>
<hr />

@isset($vendors)
	<table class="table table-striped table-bordered table-responsive dataTable">
	<thead>
	<tr>
		<th>Id</th>
		<th>Seller Name</th>
        <th>Action
	</tr>
	</thead>
	<tbody>
		@foreach( $vendors as $d )
        <tr>
            <td>{{$d->id}}</td>
            <td>{{$d->name}}</td>
            <td><a href="{{route('admin.set.commission',$d->id)}}" class="btn btn-primary">Set Commission</a></td>
        </tr>
		@endforeach
	</tbody>
	</table>
@else
	No domains in database.
@endisset

@endsection