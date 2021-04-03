@extends('admin.base')

@section('section_title')
	<strong>Period Overview</strong>
@endsection

@section('section_body')

<div class="row">
	<div class="col-xs-12 col-md-6">
		@if( empty( $p ) )
		<form method="POST" action="/admin/add-period">
		@else
		<form method="POST" action="/admin/update-period">
		<input type="hidden" name="periodId" value="{{ $p->id }}">
		Period Type:
		@endif
			{!! csrf_field() !!}
			<input type="text" name="period_type" value="{{ $p->period_type ?? '' }}" class="form-control" required>
			<br/>
			<input type="submit" name="sb" value="Save Period" class="btn btn-primary">
		</form>
	</div><!-- /.col-xs-12 col-md-6 -->
</div><!-- /.row -->

<br/>
<hr/>

@if($periods)
	<table class="table table-striped table-bordered table-responsive dataTable">
	<thead>
	<tr>
		<th>ID</th>
		<th>Period Type</th>
		<th>Actions</th>
	</tr>
	</thead>
	<tbody>
		@foreach( $periods as $p )
		<tr>
			<td>
				{!! $p->id !!}
			</td>
			<td>
				{{ $p->period_type }}
			</td>
			<td>
				 <div class="btn-group">
				 	<a class="btn btn-primary btn-xs" href="/admin/edit-period/{!! $p->id !!}">
				 		<i class="glyphicon glyphicon-pencil"></i>
				 	</a>
    				<a href="/admin/remove-period/{!! $p->id !!}" onclick="return confirm('Are you sure you want to remove this period from the database?');" class="btn btn-danger btn-xs">
						<i class="glyphicon glyphicon-remove"></i>
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