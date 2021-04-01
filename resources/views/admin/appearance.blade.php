@extends('admin.base')

@section('section_title')
<strong>Configure Appearance</strong>
@endsection

@section('extra_bottom')
<div class="row">
	<form method="POST">
	{!! csrf_field() !!}
	<div class="col-xs-12 col-md-6">
		<div class="box">
			<div class="box-header with-border"><strong>Color Setup</strong></div>
			<div class="box-body">
				<div class="form-group">
				<label>Menu Background</label>

				<div class="input-group my-colorpicker2 colorpicker-element">
				  <input type="text" class="form-control" name="menu_bg_color" value="{{ App\Options::get_option('menu_bg_color') }}">

				  <div class="input-group-addon">
				    <i style="background-color: rgb(0, 0, 0);"></i>
				  </div>
				</div>
				<!-- /.input group -->
				</div><!-- MENU_BACKGROUND -->
				<div class="form-group">
				<label>Menu Font Color</label>

				<div class="input-group my-colorpicker2 colorpicker-element">
				  <input type="text" class="form-control" name="menu_font_color" value="{{ App\Options::get_option('menu_font_color') }}">

				  <div class="input-group-addon">
				    <i style="background-color: rgb(0, 0, 0);"></i>
				  </div>
				</div>
				<!-- /.input group -->
				</div><!-- MENU FONT_COLOR -->

				<div class="form-group">
				<label>Background Color</label>

				<div class="input-group my-colorpicker2 colorpicker-element">
				  <input type="text" class="form-control" name="bg_color" value="{{ App\Options::get_option('bg_color') }}">

				  <div class="input-group-addon">
				    <i style="background-color: rgb(0, 0, 0);"></i>
				  </div>
				</div>
				<!-- /.input group -->
				</div><!-- BODY_BACKGROUND -->
				<div class="form-group">
				<label>General Font Color</label>

				<div class="input-group my-colorpicker2 colorpicker-element">
				  <input type="text" class="form-control" name="font_color" value="{{ App\Options::get_option('font_color') }}">

				  <div class="input-group-addon">
				    <i style="background-color: rgb(0, 0, 0);"></i>
				  </div>
				</div>
				<!-- /.input group -->
				</div><!-- BODY FONT_COLOR -->
			</div>
		</div>
	</div><!-- color setup -->

	<div class="col-xs-12 col-md-6">
		<div class="box">
			<div class="box-header with-border"><strong>Configuration</strong></div>
			<div class="box-body">
			<dl>
				<dt>Thumbnails Height (in pixels)</dt>
				<dd>
					<input type="number" name="column_height" value="{{ App\Options::get_option('column_height') }}">px
				</dd>
			</dl>
			</div><!-- BODY FONT_COLOR -->
		</div>
	</div><!-- color setup -->

	<div class="col-xs-12">
		<input type="submit" name="sb_settings" value="Save" class="btn btn-block btn-primary">	
	</div>

	</form>

</div><!-- ./row -->
@endsection

@section('section_body')

Here you can setup the look and feel of overall design and more!

@endsection