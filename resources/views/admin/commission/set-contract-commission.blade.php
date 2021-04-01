@extends('admin.base')
@section('section_title')
	<strong>Set Contract Commission</strong>
	<br /><br />
	{{-- <a href="/admin/domains" class="btn btn-default btn-xs">Back to Domains Overview</a> --}}
@endsection
@section('section_body')
	@if(count($commissions)>0)
	<form method="post" class="commission-form" action="{{route('store.contract.commission')}}">
		@csrf
		@foreach ($commissions as $key => $commission)
			{{-- @if ($key == 0) --}}
			<input type="hidden" name="row_id[]" value="{{$commission->id ?? ''}}">
				<div class="after-add-more tr_clone">
					<div class="col-sm-4">
						<label>From($)</label><br />
						<input type="number" name="from_domain[]" value="{{$commission->from ?? ''}}" class="form-control copy-row" required placeholder="from">
					</div>
					<div class="col-sm-4">
						<label>To($)</label><br />
						<input type="number" name="to_domain[]" value="{{$commission->to ?? ''}}" class="form-control copy-row" required placeholder="to">
					</div>
					<div class="col-sm-4">
						<label>Percentage(%)</label><br />
						<div class="input-group control-group">
							<input type="number" name="commission[]" value="{{$commission->price ?? ''}}" class="form-control copy-row" required placeholder="Percentage (%)">
							<div class="input-group-btn"> 
								<button class="btn btn-success add-more" type="button"><i class="glyphicon glyphicon-plus"></i> Add</button>
								<button class="btn btn-danger remove" id="{{$commission->id}} "type="button"><i class="glyphicon glyphicon-remove"></i> Remove</button>
							</div>
						</div>
					</div>
				</div>	
			{{-- @else --}}
				{{-- <div class="duplicate-row">
					<div class="col-sm-4">
						<input type="number" name="from_domain[]" value="{{$commission->from ?? ''}}" class="form-control" style="margin-top:10px" required placeholder="From">
					</div>
					<div class="col-sm-4">
						<input type="number" name="to_domain[]" value="{{$commission->to ?? ''}}" class="form-control" style="margin-top:10px" required placeholder="To">
					</div>
					<div class="col-sm-4">
						<div class="control-group input-group" style="margin-top:10px">
							<input type="number" name="commission[]" value="{{$commission->price ?? ''}}" class="form-control" placeholder="Price in ($)" required>
							<div class="input-group-btn"> 
								<button class="btn btn-danger remove" type="button"><i class="glyphicon glyphicon-remove"></i> Remove</button>
							</div>
						</div>
					</div>
				</div> --}}
			{{-- @endif --}}
		@endforeach
	</form>
	@else 
	<form method="post" action="{{route('store.contract.commission')}}">
		@csrf
		<div class="after-add-more tr_clone">
			<div class="col-sm-4">
				<label>From($)</label><br />
				<input type="number" name="from_domain[]" class="form-control copy-row" required placeholder="from">
			</div>
			<div class="col-sm-4">
				<label>To($)</label><br />
				<input type="number" name="to_domain[]" class="form-control copy-row" required placeholder="to">
			</div>
			<div class="col-sm-4">
				<label>Percentage (%)</label><br />
				<div class="input-group control-group">
					<input type="number" name="commission[]" class="form-control copy-row" required placeholder="Percentage (%)">
					<div class="input-group-btn"> 
						<button class="btn btn-success add-more" type="button"><i class="glyphicon glyphicon-plus"></i> Add</button>
						<button class="btn btn-danger remove" type="button"><i class="glyphicon glyphicon-remove"></i> Remove</button>
					</div>
				</div>
			</div>
		</div>
		<div class="col-xs-6 col-md-3 col-xs-offset-0 col-md-offset-3" style="margin-top:10px;margin-left:35%">
			<input type="submit" name="sb" value="Save" class="btn btn-primary btn-block">
		</div>
	</form>
	@endif
	{{-- <div class="hide copy">
		<div class="duplicate-row">
			<div class="col-sm-4">
				<input type="number" name="from_domain[]" class="form-control" style="margin-top:10px" required placeholder="From">
			</div>
			<div class="col-sm-4">
				<input type="number" name="to_domain[]" class="form-control" style="margin-top:10px" required placeholder="To">
			</div>
			<div class="col-sm-4">
				<div class="control-group input-group" style="margin-top:10px">
					<input type="number" name="commission[]" class="form-control" placeholder="Price in ($)" required>
					<div class="input-group-btn"> 
						<button class="btn btn-danger remove" type="button"><i class="glyphicon glyphicon-remove"></i> Remove</button>
					</div>
				</div>
			</div>
		</div>
	</div> --}}
	@if(count($commissions)>0)
		<div class="col-xs-6 col-md-3 col-xs-offset-0 col-md-offset-3" style="margin-top:10px;margin-left:35%">
			<input type="submit" name="sb" value="Save" class="btn save-btn btn-primary btn-block">
		</div>
	@endif


<script type="text/javascript">
$(document).ready(function() {
	$(document).on('click','.add-more',function(){
		// alert('ehl');
	var $tr    = $(this).closest('.tr_clone');
    var $clone = $tr.clone();
    $clone.find('.copy-row').val('');
    $tr.after($clone);
		// var html = $(".copy").html();
		// $(".after-add-more").after(html);
   	});
   	$("body").on("click",".remove",function(){ 
   		$(this).parents(".after-add-more").remove();
		var row_id = $(this).attr("id");
		$.ajax({
			method:"GET",
			url:"{{route('domain.commission.remove')}}",
			data : {row_id:row_id},
		});   
   	});
});

$(document).on('click','.save-btn',function(){
	$('.commission-form').submit();
});
</script>
@endsection