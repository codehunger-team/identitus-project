@extends('admin.base')

@section('section_title')
	<strong>Categories Overview</strong>
@endsection

@section('section_body')

<div class="row">
	<div class="col-xs-12 col-md-6">
		@if( empty( $catname ) )
		<form method="POST" action="{{route('admin.add.category')}}">
		@else
		<form method="POST" action="{{route('admin.update.category')}}">
		<input type="hidden" name="catID" value="{{ $catID }}">
		Category Name:
		@endif
			{!! csrf_field() !!}
			<input type="text" name="catname" value="{{ $catname }}" class="form-control">
			<br/>
			<input type="submit" name="sb" value="Save Category" class="btn btn-primary">
		</form>
	</div><!-- /.col-xs-12 col-md-6 -->
</div><!-- /.row -->

<br/>
<hr/>

@if($categories)
	<table class="table table-striped table-bordered table-responsive dataTable">
	<thead>
	<tr>
		<th>ID</th>
		<th>Domain</th>
		<th>Actions</th>
	</tr>
	</thead>
	<tbody>
		@foreach( $categories as $c )
		<tr>
			<td>
				{!! $c->id !!}
			</td>
			<td>
				{{ $c->catname }}
			</td>
			<td>
				 <div class="btn-group">
				 	<a class="btn btn-primary btn-xs mr-5" href="{{url('/')}}/admin/categories?update={!! $c->id !!}">
				 		<i class="fa fa-edit"></i>
				 	</a>	
    				<a href="{{url('/')}}/admin/categories?remove={!! $c->id !!}" onclick="return confirm('Are you sure you want to remove this category from database?');" class="btn btn-danger btn-xs">
						<i class="fa fa-trash text-white"></i>
					</a>
				</div>
			</td>
		</tr>
		@endforeach
	</tbody>
	</table>
@else
	No categories in database.
@endif

@endsection