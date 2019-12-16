@extends('layouts.index')
@section('content')
<section role="main" class="content-body">
	@include('partials.role-header')
	<div class="row">
		<div class="col-md-12">

			<section class="panel panel-featured">
				<header class="panel-heading">
					<h2 class="panel-title">{{$ppmp_type}} PPMP</h2>
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
						<!-- manage account -->
						<table id="Table1" class="table table-hover " style="width:100%;">
							<thead>
								<tr>
									<th>Status</th>
									<th>ID</th>
									<th>Course</th>
									<th>Prepared by</th>
									<th>Fiscal Year</th>
									<th>Actions</th>
								</tr>
							</thead>
							<tbody>
								@foreach($ppmps as $ppmp)
								<tr>
									<td>
										@if($ppmp->status == "Open")
										<label class="label label-xs bg-warning">{{$ppmp->status}}</label>
										@elseif($ppmp->status == "Submitted")
										<label class="label label-xs bg-primary">{{$ppmp->status}}</label>
										@elseif($ppmp->status == "Approved")
										<label class="label label-xs bg-success">{{$ppmp->status}}</label>
										@elseif($ppmp->status == "Closed")
										<label class="label label-xs bg-dark">{{$ppmp->status}}</label>
										@endif
									</td>
									<td>{{$ppmp->custom_id}}</td>
									<td>{{$ppmp->course}}</td>
									<td>{{$ppmp->prepared['name']}}</td>
									<td>{{$ppmp->fiscal_year}}</td>
									<td>
										@if($ppmp->user_id == Auth::id())
										@if(!$ppmp->prepared['signature'])
										<form method="POST" action="{{route('section.ppmp_crud')}}">
											@csrf
											<input type="hidden" name="id" value="{{$ppmp->id}}">
											<button
												style="float: left;margin-right: 4px;"
												value="sign"
												name="submit"
												type="submit"
												class="btn btn-warning">
												<span class="fas fa-pen-alt"></span> Sign
											</button>
										</form>
										@endif
										@endif
										<form method = "GET" action="{{route('section.items_list',['type'=>$type,'id'=>$ppmp->id])}}">
										@csrf
											<input type="hidden" name="id" value="{{$ppmp->id}}">
											<button
												value="open"
												name="submit"
												type="submit"
												class="btn btn-success ">
												<span class="fa fa-folder-open"></span> Open
											</button>
											<button
												id="edit"
												data-id="{{$ppmp->id}}"
												data-custom_id="{{$ppmp->custom_id}}"
												data-status="{{$ppmp->status}}"
												data-course="{{$ppmp->course}}"
												data-prepared="{{$ppmp->prepared['name']}}"
												data-fiscal_year="{{$ppmp->fiscal_year}}"
												type="button"
												class="btn btn-primary">
												<span class="fa fa-edit"></span> Edit
											</button>
											<button
												id="delete"
												data-id="{{$ppmp->id}}"
												data-custom_id="{{$ppmp->custom_id}}"
												type="button"
												class="btn btn-danger">
												<span class="fa fa-times"></span> Delete
											</button>
										</form>
									</td>
								</tr>
								@endforeach
							</tbody>
						</table>
						<!-- end manage account -->
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

// start edit
$('#edit[data-id]').on('click', function() {
	$('#EditModal').modal('show');
	$('#EditModalForm')[0].reset();
	$('h5#mediumModalLabel').html("<span class='fa fa-edit'></span> Edit "+$(this).data('custom_id'));
	$('input#status').val($(this).data('status'));
	$('input#course').val($(this).data('course'));
	$('input#prepared').val($(this).data('prepared'));
	$('input#fiscal_year').val($(this).data('fiscal_year'));
	$('input#id').val($(this).data('id'));
}); 
// end edit click

// start delete
$('#delete[data-id]').on('click', function() {
	$('#DeleteModal').modal('show');
	$('#DeleteModalForm')[0].reset();
	$('input#id').val($(this).data('id'));
	$('h5.DeleteConfirm').html('Are you sure you want to delete <b>'+$(this).data('custom_id')+'</b>?');
}); 
// end delete click

// start datatable 1
$('#Table1').DataTable({     
	"aoColumnDefs": [
	{ "bSortable": false, "aTargets": [ 5 ] }, 
	]
});
// end datatable 1
});
</script>
@endsection

@section('modals')
<!-- edit  -->
<div class="modal fade" id="EditModal" tabindex="-1" role="dialog" aria-labelledby="mediumModalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<form action="{{ route('section.ppmp_crud') }}" method="post" class="form-horizontal" id="EditModalForm">
				@csrf
				<div class="modal-header bg-primary">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span><span class="sr-only">Close</span>
					</button>
					<h5 class="modal-title" id="mediumModalLabel"></h5>
				</div>
				<div class="modal-body">
					<div class="row form-group">
						<div class="col col-md-3">
							<label class=" form-control-label">Status</label>
						</div>
						<div class="col-12 col-md-9">
							<input type="text" id="status" name="status" class="form-control" readonly>
						</div>
					</div>
					<div class="row form-group">
						<div class="col col-md-3">
							<label class=" form-control-label">Course</label>
						</div>
						<div class="col-12 col-md-9">
							<input type="text" id="course" name="course" class="form-control" required>
						</div>
					</div>
					<div class="row form-group">
						<div class="col col-md-3">
							<label class=" form-control-label">Prepared by</label>
						</div>
						<div class="col-12 col-md-9">
							<input type="text" id="prepared" name="prepared" class="form-control" required>
						</div>
					</div>
					<div class="row form-group">
						<div class="col col-md-3">
							<label class=" form-control-label">Fiscal Year</label>
						</div>
						<div class="col-12 col-md-9">
							<input type="text" id="fiscal_year" name="fiscal_year" class="form-control" required>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<!-- id and action -->
					<input type="hidden" id = "id" name="id">

					<!-- submit and cancel button -->
					<button type="submit" class="btn btn-success" name = "submit" value="update">Submit</button>
					<button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
				</div>
			</form>
		</div>
	</div>
</div>
<!-- end edit  -->

<!-- delete  -->
<div class="modal fade" id="DeleteModal" tabindex="-1" role="dialog" aria-labelledby="mediumModalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<form action="{{ route('section.ppmp_crud') }}" method="post" class="form-inline" id="DeleteModalForm">
				@csrf
				<div class="modal-header bg-danger">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
					<h5 class="modal-title"><span class="fa fa-times"></span> Delete PPMP</h5>
				</div>
				<div class="modal-body">
					<div class="modal-wrapper">
						<div class="modal-icon">
							<i class="fa fa-times-circle"></i>
						</div>
						<div class="modal-text">
							<h5 class="DeleteConfirm"></h5>
						</div>
					</div>
					<br>
				</div>
				<div class="modal-footer">
					<!-- id -->
					<input type="hidden" id = "id" name="id">

					<!-- submit and cancel button -->
					<button type="submit" class="btn btn-success" name = "submit" value="delete">Submit</button>
					<button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
				</div>
			</form>
		</div>
	</div>
</div>
<!-- end delete  -->

@endsection

