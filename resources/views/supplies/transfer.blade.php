@extends('layouts.index')
@section('content')
<section role="main" class="content-body">
	@include('partials.role-header')
	<div class="row">
		<div class="col-md-12">

			<section class="panel panel-featured">
				<header class="panel-heading">
					<h2 class="panel-title">{{$req->custom_id}}</h2>
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

					
					<div class="table-responsive">
						<table id="Table1" class="table table-hover" style="width:100%;">
							<thead>
								<tr>
									<th>Status</th>
									<th>Code</th>
									<th>Category</th>
									<th>Description</th>
									<th>Quantity</th>
									<th>Schedule</th>
									<th>Actions</th>
								</tr>
							</thead>
							<tbody>
							@foreach($items as $item)
								<tr>
									<td>
										@if($item->status == "To be fulfilled")
											<label class="label label-dark">{{$item->status}}</label>
										@elseif($item->status == "Partially fulfilled")
											<label class="label label-primary">{{$item->status}}</label>
										@elseif($item->status == "Fulfilled")
											<label class="label label-success">{{$item->status}}</label>
										@endif
									</td>
									<td>{{$item->item->code}}</td>
									<td>{{$item->item->category}}</td>
									<td>{{$item->item->description}}</td>
									<td>{{$item->quantity}} / {{$item->item->quantity}} {{$item->item->unit}}</td>
									<td>{{$item->item->schedule}}</td>
									<td>
										<button
											data-id="{{$item->id}}"
											id="supplies_modal_btn"
											type="button" 
											style="float: left; margin-right: 4px;" 
											class="btn btn-primary"><span class="fa fa-check">&nbsp;</span>Transfer
										</button>
										<button
											data-id="{{$item->id}}"
											id="logs_modal_btn"
											type="button" 
											style="float: left; margin-right: 4px;" 
											class="btn btn-dark"><span class="fa fa-file-text-o">&nbsp;</span>Logs
										</button>
									</td>
								</tr>
							@endforeach
							</tbody>
						</table>
					</div>

				</div>
			</section>

		</div>
	</div>
</section>
@endsection
@section('css')
@include('partials.import.main',['import'=>"datatable",'type'=>'css'])
<style>
	.modal-larger {
		width: 1200px;
	}
	.right-align{
		text-align: right;
	}
</style>
@endsection

@section('js')
@include('partials.import.main',['import'=>"datatable",'type'=>'js'])
@include('partials.import.main',['import'=>"cleave_js"])

<script>
$(document).ready(function(){

var cleave = new Cleave('.input_format_1', {
    numeral: true,
});

// logs_modal_btn
	$('#logs_modal_btn[data-id]').on("click", function() {
		$.ajax({
			type: "POST",
			url: "{{route('requests.modal_view')}}",
			data: {
				submit: "logs_modal_btn",
				id: $(this).data('id'),
			},
			success: function(data){
				console.log(data.items.request_items_line);

				var items_data = JSON.parse(JSON.stringify(data.items.request_items_line).replace(/null/g, '" "'));
				table2.clear().draw();

				$.each(items_data, function( k, v ) {
					var table2_data = [];

					table2_data.push(v.created_at);
					table2_data.push(v.quantity + " " + data.items.item.unit);
					table2_data.push(v.cost);
					table2_data.push(v.total);

					table2.row.add(table2_data).draw().nodes().to$();

				});	

				$('#logs_modal').modal('show');

			},
			errors: function(data){
				alert(data);
			},
		});		
	});

// supplies modal
	$('#supplies_modal_btn[data-id]').on("click", function() {
		$.ajax({
			type: "POST",
			url: "{{route('requests.modal_view')}}",
			data: {
				submit: "supplies_modal",
				id: $(this).data('id'),
			},
			success: function(data){
				console.log(data.items);
				var items_data = JSON.parse(JSON.stringify(data.items).replace(/null/g, '" "'));

				$('#ritem_id').val(items_data.id);
				$('#id').val(items_data.request_id);

				$('#code').val(items_data.item.code);
				$('#category').val(items_data.item.category);
				$('#description').val(items_data.item.description);
				$('#quantity').val(items_data.item.quantity);
				$('#quantity_on_request_span').html(" / "+items_data.item.quantity + " " + items_data.item.unit);
				$('#cost').val(items_data.item.cost);
				$('#total').val(items_data.item.total);
				$('#schedule').val(items_data.item.schedule);
				$('#supplies_modal').modal('show');

			},
			errors: function(data){
				alert(data);
			},
		});		
	});

// start datatable 1
	var table2 = $('#logs_table').DataTable();

	$('#Table1').DataTable({     
		"aoColumnDefs": [
		{ "bSortable": false, "aTargets": [ 0 ] }, 
		]
	});

});
</script>
@endsection
@section('modals')
@include('partials.modal.logs_modal')

<!-- supplies modal -->
	<div class="modal fade" id="supplies_modal" tabindex="-1" role="dialog" aria-labelledby="mediumModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-lg" role="document" id="modal-larger-class">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
					<h5 class="modal-title">Transfer</h5>
				</div>
				<form  method="post" action="{{route('requests.crud')}}" class="form-horizontal">
				@csrf
					<div class='modal-body'>
							<div class="row form-group">
								<div class="col col-md-3">
									<label for="sel1" class="col-12 col-form-label text-md-right">Code</label>
								</div>
								<div class="col-12 col-md-9">
									<input type="text" name="" id="code" class = "form-control" value="" readonly>
								</div>
							</div>
							<div class="row form-group">
								<div class="col col-md-3">
									<label for="sel1" class="col-12 col-form-label text-md-right">Category</label>
								</div>
								<div class="col-12 col-md-9">
									<input type="text" name="" id="category" class = "form-control" value="" readonly>
								</div>
							</div>
							<div class="row form-group">
								<div class="col col-md-3">
									<label for="sel1" class="col-12 col-form-label text-md-right">Description</label>
								</div>
								<div class="col-12 col-md-9">
									<input type="text" name="" id="description" class = "form-control" value="" readonly>
								</div>
							</div>
							<div class="row form-group">
								<div class="col col-md-3">
									<label for="sel1" class="col-12 col-form-label text-md-right">Quantity</label>
								</div>
								<div class="col-12 col-md-9">
									<div class="input-group">
										<input type="number" name="quantity" id="quantity" class = "form-control" placeholder="quantity" value="" required>
										<span class="input-group-addon" id="quantity_on_request_span"></span>
									</div>
								</div>
							</div>
							<div class="row form-group">
								<div class="col col-md-3">
									<label for="sel1" class="col-12 col-form-label text-md-right">Cost</label>
								</div>
								<div class="col-12 col-md-9">
									<input type="text" name="cost" id="cost" class = "form-control input_format_1" placeholder="00.00" value="" required>
								</div>
							</div>
							<div class="row form-group">
								<div class="col col-md-3">
									<label for="sel1" class="col-12 col-form-label text-md-right">Total</label>
								</div>
								<div class="col-12 col-md-9">
									<input type="text" name="total" id="total" class = "form-control" value="" readonly>
								</div>
							</div>
							<div class="row form-group">
								<div class="col col-md-3">
									<label for="sel1" class="col-12 col-form-label text-md-right">Schedule</label>
								</div>
								<div class="col-12 col-md-9">
									<input type="text" name="" id="schedule" class = "form-control" value="" readonly>
								</div>
							</div>
					</div>
					<div class="modal-footer">
						<input type="hidden" name="id" id="id">
						<input type="hidden" name="ritem_id" id="ritem_id">
						<!-- submit and cancel button -->
						<button type="submit" class="btn btn-success" name="submit" value="supplies_transfer">Submit</button>
						<button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
					</div>
				</form>
			</div>
		</div>
	</div>

@endsection

