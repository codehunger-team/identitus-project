@extends('admin.base')

@section('section_title')
	<strong>Customer Enquiry</strong>
@endsection

@section('section_body')

@if($contacts)
	<table class="table table-striped table-bordered table-responsive dataTable">
	<thead>
		<tr>
			<th>Name</th>
			<th>Email</th>
			<th>Message</th>
		</tr>
	</thead>
	<tbody>
		@foreach( $contacts as $contact )
		<tr>
			<td>
				{{ $contact->name }}
			</td>
			<td>
				{{ $contact->email }}
			</td>
            <td>
				{{ $contact->message }}
			</td>
		</tr>
		@endforeach
	</tbody>
	</table>
@else
	No Period Type in database.
@endif

@endsection