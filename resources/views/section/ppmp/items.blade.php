@extends('layouts.index')
@section('content')
<section role="main" class="content-body">
	@include('partials.role-header')

	@if($ppmp->type == "Supplies/Equipment")
	<div class="row">
		<div class="col-xs-6 col-sm-6 col-md-4 col-md-offset-1">
			<section class="panel ">
				<div class="panel-body bg-primary">
					<div class="widget-summary">
						<div class="widget-summary-col widget-summary-col-icon">
							<div class="summary-icon bg-secondary">
								<span>₱</span>
							</div>
						</div>
						<div class="widget-summary-col">
							<div class="summary">
								<h4 class="title">Supplies Budget Remaining</h4>
								<div class="info" id = "SuppliesBudgetcard">
									<strong class="amount" >Php {{number_format($budget->course->supplies, 2)}}</strong>
								</div>
							</div>
						</div>
					</div>
				</div>
			</section>
		</div>
		<div class=" col-xs-6 col-sm-6 col-md-4 col-md-offset-1">
			<section class="panel">
				<div class="panel-body bg-quartenary">
					<div class="widget-summary">
						<div class="widget-summary-col widget-summary-col-icon">
							<div class="summary-icon bg-quartenary">
								<span>₱</span>
							</div>
						</div>
						<div class="widget-summary-col">
							<div class="summary">
								<h4 class="title">Equipment Budget Remaining</h4>
								<div class="info" id = "EquipmentBudgetcard">
									<strong class="amount" >Php {{number_format($budget->course->equipment, 2)}}</strong>
								</div>
							</div>
						</div>
					</div>
				</div>
			</section>
		</div>
	</div>
	@elseif($ppmp->type == "Supplemental")
	<div class="row">
		<div class="col-xs-12">
			<div class="col-md-6 col-md-offset-3 col-xs-12">
				<section class="panel">
					<div class="panel-body bg-info">
						<div class="widget-summary">
							<div class="widget-summary-col widget-summary-col-icon">
								<div class="summary-icon bg-warning">
									<span>₱</span>
								</div>
							</div>
							<div class="widget-summary-col">
								<div class="summary">
									<h4 class="title">Supplemental Budget Remaining</h4>
									<div class="info" id = "SupplementalBudgetcard">
										<strong class="amount" >Php {{number_format($budget->course->supplemental, 2)}}</strong>
									</div>
								</div>
							</div>
						</div>
					</div>
				</section>
			</div>    
		</div>
	</div>
	@endif

	<!-- start row -->
	<div class="row">
		<div class="col-md-12">

			<section class="panel panel-featured">
				<header class="panel-heading">
					<h2 class="panel-title">{{$ppmp->type}} {{$ppmp->custom_id}}</h2>
				</header>
				<div class="panel-body" style="display: block;">
					@if ($errors->any())
					<div class="alert alert-danger">
						<ul>
							@foreach ($errors->all() as $error)
							<li>{{ $error }}</li>
							@endforeach
						</ul>
					</div>
					@endif

					@if(session('success'))
					<div class="alert alert-success">
						{{session('success')}}
					</div>
					@endif

					<div class="row">
						<div class="col col-md-12">
						@if($ppmp->status == "Approved" or $ppmp->status == "Closed")
						<form action="{{route('print.ppmp')}}" method="POST" target="_blank" class="form-horizontal">
						@csrf
							<input type="hidden" name="id" value="{{$ppmp->id}}">
							<button 
								value="print" 
								name="submit" 
								type="submit" 
								class="btn btn-primary"><span class="fa fa-print"></span> Print
							</button>
						</form>
						@else
							<form action="{{ route('section.ppmp_crud') }}" method="post" class="form-horizontal">
								<button 
								id="add" 
								data-id="{{$ppmp->id}}"
								type="button" 
								class="btn btn-success"><span class="fa fa-plus"></span> Add Item
							</button>
							@if($ppmp->item->count() > 0 and $ppmp->status == "Open")
							@csrf
							<input type="hidden" name="submit_id" value="{{$ppmp->id}}">
							<button 
								value="submit" 
								name="submit" 
								type="submit" 
								class="btn btn-primary"><span class="fa fa-check"></span> Submit PPMP
							</button>
							@endif
						</form>
						@endif
					</div>
				</div>
			<br>
			<form action="{{ route('section.items_crud') }}" method="post" class="form-horizontal" style="border-top: solid;">
				@csrf
				<br>
				<div class="table-responsive">
					<!-- ppmp items -->
					<table id="Table1" class="table table-hover " style="width:100%;">
						<thead>
							<tr>
								<th>Status</th>
								<th>Code</th>
								<th>Category</th>
								<th>Description</th>
								<th>Quantity</th>
								<th>Cost</th>
								<th>Total</th>
								<th>Schedule</th>
								<th>Actions</th>
							</tr>
						</thead>
						<tbody>
							@foreach($items as $item)
							<tr>
								<td>
									@if($item->status == "New")
									<label class="label label-xs bg-dark">{{$item->status}}</label>
									@elseif($item->status == "Reviewed")
									<label class="label label-xs bg-warning">{{$item->status}}</label>
									@elseif($item->status == "ForRevision")
									<label class="label label-xs bg-danger">For Revision</label>
									@elseif($item->status == "Evaluated")
									<label class="label label-xs bg-primary">{{$item->status}}</label>
									@elseif($item->status == "Approved")
									<label class="label label-xs bg-success">{{$item->status}}</label>
									@endif
								</td>
								<td>{{$item->code}}</td>
								<td>{{$item->category}}</td>
								<td>{{$item->description}}</td>
								<td>{{$item->quantity}} {{$item->unit}}</td>
								<td>{{number_format($item->cost,2)}}</td>
								<td>{{number_format($item->total,2)}}</td>
								<td>{{$item->schedule}}</td>
								<td>
									<input type="hidden" name="id" value="{{$item->id}}">
									<button 
									id="update" 
									data-id="{{$item->id}}"
									data-code="{{$item->code}}"
									data-category="{{$item->category}}"
									data-description="{{$item->description}}"
									data-quantity="{{$item->quantity}}"
									data-unit="{{$item->unit}}"
									data-cost="{{$item->cost}}"
									data-total="{{$item->total}}"
									data-schedule="{{$item->schedule}}"
									type="button" 
									class="btn btn-primary">
									<span class="fa fa-edit"></span> Edit 
								</button>
								<button 
								value="delete" 
								name="submit" 
								class="btn btn-danger"> 
								<span class="fa fa-times"></span> Delete
							</button>
						</td>
					</tr>
					@endforeach
				</tbody>
			</table>
			<!-- end ppmp items -->
		</div>
	</form>
	<br>
	<div  class = "row">
		<div class = "col-md-4">
			<p><b>Supplies Total: Php {{number_format($supplies_total,2)}}</b></p>
		</div>
		<div class = "col-md-4">
			<p><b>Equipment Total: Php {{number_format($equipment_total,2)}}</b></p>
		</div>
		<div class = "col-md-4">
			<p><b>Grand Total: Php {{number_format($supplies_total + $equipment_total,2)}}</b></p>
		</div>
	</div>
</div>
</section>
</div>
</div>		
</section>
@endsection
@section('css')
@include('partials.import.main',['import'=>"datatable",'type'=>'css'])
@include('partials.import.main',['import'=>"bs_multiselect",'type'=>'css'])
@endsection

@section('js')
@include('partials.import.main',['import'=>"datatable",'type'=>'js'])
@include('partials.import.main',['import'=>"bs_multiselect",'type'=>'js'])
@include('partials.import.main',['import'=>"cleave_js"])

<script>
	$(document).ready(function(){

// format input
var cleave = new Cleave('.input_format_1', {
	numeral: true,
	numeralThousandsGroupStyle: 'thousand'
});

var cleave = new Cleave('.input_format_2', {
	numeral: true,
	numeralThousandsGroupStyle: 'thousand'
});

$('select#schedule_1[multiple]').multiselect({ 
	buttonText: function(options, select) {
		Schedule = [];
		options.each(function() {
			Schedule.push($(this).val());
		});

		$('input#GetSchedule').val(Schedule);

		if (options.length === 0) {
			return 'Schedule <b class = "caret"></b>';
		}
		if (options.length === select[0].length) {
			return 'All selected <b class = "caret"></b>';
		}
		else if (options.length >= 3) {
			return options.length + ' selected <b class = "caret"></b>';
		}
		else {
			var labels = [];
			options.each(function() {
				labels.push($(this).val());
			});
			return labels.join(', ') + ' <b class = "caret"></b>';
		}
	}
}); 
//end multiselect 1

$('#UpdateSubmitBtn').click(function(){
	var arr = [];
	$.each($('option[name="date"]:checked'), function() {
		arr.push($(this).val());
	})
	var Schedule = arr.join(',') ;

	$('#update_schedule').val(Schedule);
});

$('#add[data-id]').on('click', function() {
	$('#AddModal').modal('show');
	$('#AddModalForm')[0].reset();
	$('input#name').val($(this).data('name'));
	$('input#id').val($(this).data('id'));
});

$('#update[data-id]').on('click', function() {
	$('#EditModal').modal('show');
	$('#EditModalForm')[0].reset();

	$('input#code').val($(this).data('code'));
	$('input#description').val($(this).data('description'));
	$('input#quantity').val($(this).data('quantity'));
	$('input#unit').val($(this).data('unit'));
	$('input#cost').val($(this).data('cost'));

	$('input#id').val($(this).data('id'));

	$('select[name^="category"]').val($(this).data('category'));

	var dates = $(this).data('schedule');
	var date = dates.split(',');
	$('select#schedule_2[multiple]').multiselect('refresh');
	$('select#schedule_2[multiple]').multiselect('select', date);

	$('select#schedule_2[multiple]').multiselect({ 
		buttonText: function(options, select) {

			if (options.length === 0) {
				return 'Schedule <b class = "caret"></b>';
			}
			if (options.length === select[0].length) {
				return 'All selected <b class = "caret"></b>';
			}
			else if (options.length >= 3) {
				return options.length + ' selected <b class = "caret"></b>';
			}
			else {
				var labels = [];
				options.each(function() {
					labels.push($(this).val());
				});
				return labels.join(', ') + ' <b class = "caret"></b>';
			}
		}
	}); 
	//end multiselect 2

});
// end update btn


// start datatable 1
$('#Table1').DataTable({     
	"aoColumnDefs": [
	{ "bSortable": false, "aTargets": [ 8 ] }, 
	]
});
// end datatable 1
});
</script>
@endsection

@section('modals')

<!-- EditModal  -->
<div class="modal fade" id="EditModal" tabindex="-1" role="dialog" aria-labelledby="mediumModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<form action="{{ route('section.items_crud') }}" method="post" class="form-horizontal" id="EditModalForm">
				@csrf
				<div class="modal-header bg-primary">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span><span class="sr-only">Close</span>
					</button>
					<h5 class="modal-title" id="mediumModalLabel"><span class="fa fa-edit"></span> Edit Item</h5>
				</div>
				<div class="modal-body">
					<div class="row form-group">
						<div class="col col-md-3">
							<label class=" form-control-label">Code</label>
						</div>
						<div class="col-12 col-md-9">
							<input type="text" id="code" name="code" placeholder="Code..." class="form-control">
						</div>
					</div>
					<div class="row form-group">
						<div class="col col-md-3">
							<label class=" form-control-label">Category <span style="color: red;">*</span></label>
						</div>
						<div class="col-12 col-md-9">
							<select name="category" class="form-control">
								<option name="Supplies" value="Supplies">Supplies</option>
								<option name="Equipment" value="Equipment">Equipment</option>
							</select>
						</div>
					</div>
					<div class="row form-group">
						<div class="col col-md-3">
							<label class=" form-control-label">Description <span style="color: red;">*</span></label>
						</div>
						<div class="col-12 col-md-9">
							<input type="text" id="description" name="description" placeholder="Description..." class="form-control" required>
						</div>
					</div>
					<div class="row form-group">
						<div class="col col-md-3">
							<label class=" form-control-label">Quantity <span style="color: red;">*</span></label>
						</div>
						<div class="col-12 col-md-9">
							<input type="text" id="quantity" name="quantity" placeholder="Quantity..." class="form-control" required>
						</div>
					</div>
					<div class="row form-group">
						<div class="col col-md-3">
							<label class=" form-control-label">Unit <span style="color: red;">*</span></label>
						</div>
						<div class="col-12 col-md-9">
							<input type="text" id="unit" name="unit" placeholder="Unit..." class="form-control" required>
						</div>
					</div>
					<div class="row form-group">
						<div class="col col-md-3">
							<label class=" form-control-label">Estimated Cost <span style="color: red;">*</span></label>
						</div>
						<div class="col-12 col-md-9">
							<input type="text" name="cost" id="cost" class = "form-control input_format_2" placeholder="00.00" required>
						</div>
					</div>
					<div class="row form-group">
						<div class="col col-md-3">
							<label class=" form-control-label">Schedule <span style="color: red;">*</span></label>
						</div>
						<div class="col-12 col-md-9">
							<select class = "schedule_2" id="schedule_2" name="schedule_2" multiple="multiple" size="12">
								<option name="date" value="Jan">January</option>
								<option name="date" value="Feb">February</option>
								<option name="date" value="Mar">March</option>
								<option name="date" value="Apr">April</option>
								<option name="date" value="May">May</option>
								<option name="date" value="June">June</option>
								<option name="date" value="July">July</option>
								<option name="date" value="Aug">August</option>
								<option name="date" value="Sept">September</option>
								<option name="date" value="Oct">October</option>
								<option name="date" value="Nov">November</option>
								<option name="date" value="Dec">December</option>
							</select>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<!-- item id -->
					<input type="hidden" id = "id" name="id">
					<input type="hidden" id = "update_schedule" name="update_schedule">

					<!-- submit and cancel button -->
					<button type="submit" class="btn btn-success" name="submit" value="update" id="UpdateSubmitBtn">Submit</button>
					<button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
				</div>
			</form>
		</div>
	</div>
</div>
<!-- end EditModal  -->

<!-- AddModal  -->
<div class="modal fade" id="AddModal" tabindex="-1" role="dialog" aria-labelledby="mediumModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<form action="{{ route('section.items_crud') }}" method="post" class="form-horizontal" id="AddModalForm">
				@csrf
				<div class="modal-header bg-success">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span><span class="sr-only">Close</span>
					</button>
					<h5 class="modal-title" id="mediumModalLabel"><span class="fa fa-plus"></span> Add Item</h5>
				</div>
				<div class="modal-body">
					<div class="row form-group">
						<div class="col col-md-3">
							<label class=" form-control-label">Code</label>
						</div>
						<div class="col-12 col-md-9">
							<input type="text" id="code" name="code" placeholder="Code..." class="form-control">
						</div>
					</div>
					<div class="row form-group">
						<div class="col col-md-3">
							<label class=" form-control-label">Category <span style="color: red;">*</span></label>
						</div>
						<div class="col-12 col-md-9">
							<select name="category" class="form-control">
								<option name="Supplies" value="Supplies">Supplies</option>
								<option name="Equipment" value="Equipment">Equipment</option>
							</select>
						</div>
					</div>
					<div class="row form-group">
						<div class="col col-md-3">
							<label class=" form-control-label">Description <span style="color: red;">*</span></label>
						</div>
						<div class="col-12 col-md-9">
							<input type="text" id="description" name="description" placeholder="Description..." class="form-control" required>
						</div>
					</div>
					<div class="row form-group">
						<div class="col col-md-3">
							<label class=" form-control-label">Quantity <span style="color: red;">*</span></label>
						</div>
						<div class="col-12 col-md-9">
							<input type="text" id="quantity" name="quantity" placeholder="Quantity..." class="form-control" required>
						</div>
					</div>
					<div class="row form-group">
						<div class="col col-md-3">
							<label class=" form-control-label">Unit <span style="color: red;">*</span></label>
						</div>
						<div class="col-12 col-md-9">
							<input type="text" id="unit" name="unit" placeholder="Unit..." class="form-control" required>
						</div>
					</div>
					<div class="row form-group">
						<div class="col col-md-3">
							<label class=" form-control-label">Estimated Cost <span style="color: red;">*</span></label>
						</div>
						<div class="col-12 col-md-9">
							<input type="text" name="cost" id="cost" class = "form-control input_format_1" placeholder="00.00" required>
						</div>
					</div>
					<div class="row form-group">
						<div class="col col-md-3">
							<label class=" form-control-label">Schedule <span style="color: red;">*</span></label>
						</div>
						<div class="col-12 col-md-9">
							<select id="schedule_1" name="schedule_1" multiple="multiple" size="12">
								<option name="date" value="Jan">January</option>
								<option name="date" value="Feb">February</option>
								<option name="date" value="Mar">March</option>
								<option name="date" value="Apr">April</option>
								<option name="date" value="May">May</option>
								<option name="date" value="June">June</option>
								<option name="date" value="July">July</option>
								<option name="date" value="Aug">August</option>
								<option name="date" value="Sept">September</option>
								<option name="date" value="Oct">October</option>
								<option name="date" value="Nov">November</option>
								<option name="date" value="Dec">December</option>
							</select>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<!-- id -->
					<input type="hidden" id = "id" name="id">
					<input type="hidden" id = "GetSchedule" name="GetSchedule">

					<!-- submit and cancel button -->
					<button type="submit" class="btn btn-success" name="submit" value="add">Submit</button>
					<button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
				</div>
			</form>
		</div>
	</div>
</div>
<!-- end AddModal  -->
@endsection



