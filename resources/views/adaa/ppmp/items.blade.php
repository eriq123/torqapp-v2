@extends('layouts.index')
@section('content')
<section role="main" class="content-body">
	@include('partials.role-header')

	<!-- start row -->
	<div class="row">
		<div class="col-md-12">

			<section class="panel panel-featured">
				<header class="panel-heading">
					<h2 class="panel-title">{{$ppmp->type}} {{$ppmp->custom_id}}</h2>
					<p class="subtitle">{{$ppmp->course}}</p>
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
									style="float: left;margin-right: 4px;"
									value="print" 
									name="submit" 
									type="submit" 
									class="btn btn-primary"><span class="fa fa-print"></span> Print
								</button>
							</form>
							@endif
							<form action="{{ route('adaa.items_crud') }}" method="post" class="form-horizontal">
								@csrf
								<input type="hidden" name="id" id="id">
								<button 
									id="review" 
									value="review" 
									name="submit" 
									type="submit" 
									class="btn btn-success"><span class="fa fa-check"></span> Review
								</button>
								<button 
									id="revision" 
									type="button" 
									class="btn btn-danger"><span class="fa fa-times"></span> For Revision
								</button>
							</form>
						</div>
					</div>
				<br>
				<form class="form-horizontal" style="border-top: solid;">
					<br>
					<div class="table-responsive">
						<table id="Table1" class="table table-hover " style="width:100%;">
							<thead>
								<tr>
									@if($ppmp->status == "Submitted")
									<th>
										<input type="checkbox" id="parent" value="">
									</th>
									@endif
									<th>Status</th>
									<th>Code</th>
									<th>Category</th>
									<th>Description</th>
									<th>Quantity</th>
									<th>Cost</th>
									<th>Total</th>
									<th>Schedule</th>
									<th></th>
								</tr>
							</thead>
							<tbody>
								@foreach($items as $item)
								<tr>
									@if($ppmp->status == "Submitted")
									<td>
										@if($item->status == "Approved")
										<input type="checkbox" value="{{$item->id}}" disabled >
										@else
										<input type="checkbox" class="child" value="{{$item->id}}">
										@endif
									</td>
									@endif
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
										@if($item->status == "ForRevision")
										<button 
										id="comment" 
										data-id="{{$item->id}}"
										data-comment="{{$item->comment}}"
										type="button" 
										class="btn btn-info">
										<span class="fa fa-comment"></span>
									</button>
									@endif
								</td>
							</tr>
							@endforeach
						</tbody>
					</table>
				</div>
			</form>
			<br>
			<div class = "row">
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
@endsection

@section('js')
@include('partials.import.main',['import'=>"datatable",'type'=>'js'])

<script>
	$(document).ready(function(){

		$("#parent").click(function() {
			$(".child").prop("checked", this.checked);
		});

		$('.child').click(function() {
			if ($('.child:checked').length == $('.child').length) {
				$('#parent').prop('checked', true);
			} else {
				$('#parent').prop('checked', false);
			}
		});

		$("#review").click(function() {
			id = [];
			$('.child:checked').each(function(index){
				id.push($(this).val());
			});	
			$('#id').val(id);
		});

		$("#revision").click(function() {
			id = [];
			$('.child:checked').each(function(index){
				id.push($(this).val());
			});	

			$('#DeclineModal').modal('show');
			$('#DeclineModalForm')[0].reset();
			$('input#id').val(id);
		});

// start comment
$('#comment[data-id]').on('click', function() {
	$('#CommentModal').modal('show');
	$('textarea#comment').val($(this).data('comment'));
}); 
// end comment click

// start datatable 1
$('#Table1').DataTable({     
	"aoColumnDefs": [
	{ "bSortable": false, "aTargets": [ 0 ] }, 
	]
});
// end datatable 1
});
</script>
@endsection

@section('modals')
<!-- decline  -->
<div class="modal fade" id="CommentModal" tabindex="-1" role="dialog" aria-labelledby="mediumModalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span><span class="sr-only">Close</span>
				</button>
				<h5 class="modal-title" id="mediumModalLabel">Comment</h5>
			</div>
			<div class="modal-body">
				<textarea name="comment" id="comment" class="form-control" rows="5" readonly></textarea>
			</div>
		</div>
	</div>
</div>
<!-- end decline  -->

<!-- decline  -->
<div class="modal fade" id="DeclineModal" tabindex="-1" role="dialog" aria-labelledby="mediumModalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<form action="{{ route('adaa.items_crud') }}" method="post" class="form-horizontal" id="DeclineModalForm">
				@csrf
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span><span class="sr-only">Close</span>
					</button>
					<h5 class="modal-title" id="mediumModalLabel">Comment</h5>
				</div>
				<div class="modal-body">
					<p>Please enter comment below:</p>

					<textarea name="comment" id="comment" class="form-control" rows="5"></textarea>
				</div>
				<div class="modal-footer">
					<!-- id and action -->
					<input type="hidden" id = "id" name="id">

					<!-- submit and cancel button -->
					<button type="submit" class="btn btn-success" name = "submit" value="revision">Submit</button>
					<button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
				</div>
			</form>
		</div>
	</div>
</div>
<!-- end decline  -->
@endsection



