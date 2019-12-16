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
							<form action="{{ route('director.items_crud') }}" method="post" class="form-horizontal">
								@csrf
								<input type="hidden" name="id" id="id">
								<input type="hidden" name="ppmp_id" id="ppmp_id" value="{{$ppmp->id}}">
								<button 
								id="approve" 
								value="approve" 
								name="submit" 
								type="submit" 
								class="btn btn-success"><span class="fa fa-check"></span> Approve
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
									<th>
										<input type="checkbox" id="parent" value="" checked>
									</th>
									<th>Status</th>
									<th>Code</th>
									<th>Category</th>
									<th>Description</th>
									<th>Quantity</th>
									<th>Cost</th>
									<th>Total</th>
									<th>Schedule</th>
								</tr>
							</thead>
							<tbody>
								@foreach($items as $item)
								<tr>
									<td>
										@if($item->status == "Evaluated")
										<input type="checkbox" class="child" value="{{$item->id}}" checked>
										@else
										<input type="checkbox" class="" value="{{$item->id}}" disabled>
										@endif
									</td>
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

		$("#approve").click(function() {
			id = [];
			$('.child:checked').each(function(index){
				id.push($(this).val());
			});	
			$('#id').val(id);
		});

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

@endsection



