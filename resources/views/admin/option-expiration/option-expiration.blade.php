@extends('admin.base')

@section('section_title')
	<strong>Option Overview</strong>
@endsection

@section('section_body')

<div class="row">
	<div class="col-xs-12 col-md-6">
		@if( empty( $o ) )
		<form method="POST" action="{{route('admin.add.option')}}">
		@else
		<form method="POST" action="{{route('admin.update.option')}}">
		<input type="hidden" name="optionId" value="{{ $o->id }}">
		Option Expiration:
		@endif
			{!! csrf_field() !!}
			<input type="text" name="option_expiration" value="{{ $o->option_expiration ?? '' }}" class="form-control" required>
			<br/>
			<input type="submit" name="sb" value="Option Expiration" class="btn btn-primary">
		</form>
	</div><!-- /.col-xs-12 col-md-6 -->
</div><!-- /.row -->

<br/>
<hr/>

@if($options)
	<table class="table table-striped table-bordered table-responsive dataTable">
	<thead>
	<tr>
		<th>ID</th>
		<th>Option Expiration</th>
		<th>Actions</th>
	</tr>
	</thead>
	<tbody>
		@foreach( $options as $o )
		<tr>
			<td>
				{!! $o->id !!}
			</td>
			<td>
				{{ $o->option_expiration }}
			</td>
			<td>
				 <div class="btn-group">					
				 	<a class="btn btn-primary btn-xs" href="{{route('admin.edit.option',$o->id)}}">
				 		<i class="glyphicon glyphicon-pencil"></i>
				 	</a>	
    				<a href="{{route('admin.remove.option',$o->id)}}" onclick="return confirm('Are you sure you want to remove this option from the database?');" class="btn btn-danger btn-xs">
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