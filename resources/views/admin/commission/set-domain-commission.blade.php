@extends('admin.base')
@section('section_title')
	<strong>Set Domain Commission</strong>
	<a href="{{route('admin.add.commission')}}" class="btn btn-primary btn-xs float-end">Back to Add Commission</a>
@endsection
@section('section_body')
	@if(count($commissions)>0)
	<form method="post" class="commission-form" action="{{route('store.domain.commission')}}">
		@csrf
		@foreach ($commissions as $key => $commission)
			<input type="hidden" name="row_id[]" value="{{$commission->id ?? ''}}">
				<div class="after-add-more tr_clone">
					<div class="col-sm-4">
						<label>From</label><br />
						<input type="number" name="from_domain[]" value="{{$commission->from ?? ''}}" class="form-control copy-row" required placeholder="from">
					</div>
					<div class="col-sm-4">
						<label>To</label><br />
						<input type="number" name="to_domain[]" value="{{$commission->to ?? ''}}" class="form-control copy-row" required placeholder="to">
					</div>
					<div class="col-sm-4">
						<label>Price($)</label><br />
						<div class="input-group control-group">
							<input type="number" name="commission[]" value="{{$commission->price ?? ''}}" class="form-control copy-row" required placeholder="price in ($)">
							<div class="input-group-btn"> 
								<button class="btn btn-success add-more" type="button"><i class="glyphicon glyphicon-plus"></i> Add</button>
								<button class="btn btn-danger remove" id="{{$commission->id}} "type="button"><i class="glyphicon glyphicon-remove"></i> Remove</button>
							</div>
						</div>
					</div>
				</div>
		@endforeach
	</form>
	@else 
	<form method="post" action="{{route('store.domain.commission')}}">
		@csrf
		<div class="row after-add-more tr_clone">
			<div class="col-sm-4">
				<label>From</label><br />
				<input type="number" name="from_domain[]" class="form-control copy-row" required placeholder="from">
			</div>
			<div class="col-sm-4">
				<label>To</label><br />
				<input type="number" name="to_domain[]" class="form-control copy-row" required placeholder="to">
			</div>
			<div class="col-sm-4">
				<label>Price($)</label><br />
				<div class="input-group control-group">
					<input type="number" name="commission[]" class="form-control copy-row" required placeholder="price in ($)">
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
	@if(count($commissions)>0)
		<div class="col-xs-6 col-md-3 col-xs-offset-0 col-md-offset-3" style="margin-top:10px;margin-left:35%">
			<input type="submit" name="sb" value="Save" class="btn save-btn btn-primary btn-block">
		</div>
	@endif
<script>
$(document).ready(function() {
	$(document).on('click','.add-more',function(){
	var $tr    = $(this).closest('.tr_clone');
    var $clone = $tr.clone();
    $clone.find('.copy-row').val('');
    $tr.after($clone);
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