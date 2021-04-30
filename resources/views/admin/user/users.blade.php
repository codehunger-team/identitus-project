@extends('admin.base')

@section('section_title')
	<strong>Registered Users</strong>
@endsection

@section('section_body')

@if($users)
	<table class="table table-striped table-bordered table-responsive dataTable">
	<thead>
		<tr>
			<th>User ID</th>
			<th>User Name</th>
			<th>Is Vendor</th>
			<th>Applied For Vendor</th>
			<th>Actions</th>
		</tr>
	</thead>
	<tbody>
		@foreach( $users as $user )
		<tr>
			<td>
				{!! $user->id !!}
			</td>
			<td>
				{{ $user->name }}
			</td>
			@if($user->is_vendor == 'yes')
			<td>
				Yes
			</td>
			@else
			<td>
				No
			</td> 
			@endif
			@if($user->is_vendor == 'pending')
			<td>
				<a class="btn btn-primary btn-xs" href="{{url('admin/approve-user-vendor',$user->id)}}">
						Need Approval
				</a>
			</td>
			@elseif($user->is_vendor == 'yes') 
			<td>
				<a class="btn btn-success btn-xs" href="{{url('admin/approve-user-vendor',$user->id)}}">
					Approved
				</a>
			</td>
			@else
			<td>
				No				
			</td>
			@endif
 			<td>
				<div class="btn-group">
					<a data-toggle="tooltip" title="View Details" href="{{url('admin/approve-user-vendor',$user->id)}}"  class="btn btn-primary btn-xs mr-5">
						<i class="fa fa-eye" aria-hidden="true"></i>
					</a>																	
    				<a data-toggle="tooltip" title="Delete User" href="{{url('admin/remove-user/',$user->id)}}" onclick="return confirm('Are you sure you want to remove this user from the database ?');" class="btn btn-danger btn-xs">
						<i class="fa fa-trash text-white"></i>
					</a>
				</div>
			</td>
		</tr>
		@endforeach
	</tbody>
	</table>
@else
	No Period Type in database.
@endif

@endsection