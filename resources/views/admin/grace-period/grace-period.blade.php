@extends('admin.base')

@section('section_title')
	<strong>Grace Period</strong>
@endsection

@section('section_body')

<div class="row">
	<div class="col-xs-12 col-md-6">
		@if( empty( $g ) )
		<form method="POST" action="/admin/add-grace">
		@else
		<form method="POST" action="/admin/update-grace">
		<input type="hidden" name="graceId" value="{{ $g->id }}">
		Grace Period:
		@endif
			{!! csrf_field() !!}
			<input type="text" name="grace_period" value="{{ $g->grace_period ?? '' }}" class="form-control" required>
			<br/>
			<input type="submit" name="sb" value="Submit" class="btn btn-primary">
		</form>
	</div><!-- /.col-xs-12 col-md-6 -->
</div><!-- /.row -->

<br/>
<hr/>

@if($grace)
	<table class="table table-striped table-bordered table-responsive dataTable">
	<thead>
	<tr>
		<th>ID</th>
		<th>Grace Period</th>
		<th>Actions</th>
	</tr>
	</thead>
	<tbody>
		@foreach( $grace as $g )
		<tr>
			<td>
				{!! $g->id !!}
			</td>
			<td>
				{{ $g->grace_period }}
			</td>
			<td>
				 <div class="btn-group">
				 	<a class="btn btn-primary btn-xs" href="/admin/edit-grace/{!! $g->id !!}">
				 		<i class="glyphicon glyphicon-pencil"></i>
				 	</a>
    				<a href="/admin/remove-grace/{!! $g->id !!}" onclick="return confirm('Are you sure you want to remove this grace period from the database?');" class="btn btn-danger btn-xs">
						<i class="glyphicon glyphicon-remove"></i>
					</a>
				</div>
			</td>
		</tr>
		@endforeach
	</tbody>
	</table>
@else
	No Grace Type in database.
@endif

@endsection