@extends('layouts.index')
@section('content')
<section role="main" class="content-body">
	@include('partials.role-header')
	<div class="row">
		<div class="col-md-12">

			<section class="panel panel-featured">
				<header class="panel-heading">
					<h2 class="panel-title">Departments</h2>
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
					<!-- add department -->
					<form action = "{{ route ('admin.department_crud') }}" method="post" class="form-horizontal" style="border-bottom: solid;">
						@csrf
						<div class="form-group">
							<label class="col-md-3 control-label" for="name">Department Name:</label>

							<div class = "col-md-6">
								<div class="input-group mb-md">
									<input type="text" class="form-control" name = "name" placeholder="Enter department name..." required>
									<div class="input-group-btn">
										<input type="hidden" name="action" value="add">
										<button class="btn btn-success" type="submit" style="white-space: nowrap;"><i class="fa fa-plus"></i> Add</button>
									</div>
								</div>
							</div>
						</div>
					</form>
					<!-- end add department -->
					<br>

					<div class="table-responsive">
						<!-- edit department -->
						<table id="Table1" class="table table-hover " style="width:100%;">
							<thead>
								<tr>
									<th width="60%">Departments</th>
									<th width="40%">Actions</th>
								</tr>
							</thead>
							<tbody>
								@foreach($departments as $department)
									<tr>
										<td>{{ $department->name }}</td>
										<td>
											<button 
												class="btn btn-primary" 
												id="edit" 
												data-id = "{{$department->id}}" 
												data-name = "{{$department->name}}">
												<span class="fa fa-edit"></span> Edit
											</button>
												<button 
												class="btn btn-danger" 
												id="delete" 
												data-id = "{{$department->id}}" 
												data-name = "{{$department->name}}">
												<span class="fa fa-times"></span> Delete
											</button>
										</td>
									</tr>
								@endforeach
							</tbody>
						</table>
						<!-- end edit department -->
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
//start document ready
$( document ).ready(function() {

// start edit
$('#edit[data-id]').on('click', function() {
	$('#EditModal').modal('show');
	$('#EditModalForm')[0].reset();
	$('input#name').val($(this).data('name'));
	$('input#id').val($(this).data('id'));
}); 
// end edit click

// start delete
$('#delete[data-id]').on('click', function() {
	$('#DeleteModal').modal('show');
	$('#DeleteModalForm')[0].reset();
	$('input#name').val($(this).data('name'));
	$('input#id').val($(this).data('id'));
	$('h5.DeleteConfirm').empty();
	$('h5.DeleteConfirm').append('Are you sure you want to delete the <b>'+$(this).data('name')+'</b> department?');
}); 
// end delete click

// start datatable 1
$('#Table1').DataTable({     
	"aoColumnDefs": [
	{ "bSortable": false, "aTargets": [ 1 ] }, 
	]
});
// end datatable 1
});
// end document ready
</script>
@endsection

@section('modals')
<!-- edit  -->
<div class="modal fade" id="EditModal" tabindex="-1" role="dialog" aria-labelledby="mediumModalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<form action="{{ route('admin.department_crud') }}" method="post" class="form-horizontal" id="EditModalForm">
				@csrf
				<div class="modal-header bg-primary">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span><span class="sr-only">Close</span>
					</button>
					<h5 class="modal-title" id="mediumModalLabel"><span class="fa fa-edit"></span> Edit Department</h5>
				</div>
				<div class="modal-body">
					<div class="row form-group">
						<div class="col col-md-3">
							<label class=" form-control-label">Department Name</label>
						</div>
						<div class="col-12 col-md-9">
							<input type="text" id="name" name="name" placeholder="Enter Department Name..." class="form-control" required>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<!-- id and action -->
					<input type="hidden" id = "id" name="id">
					<input type="hidden" id = "action" name="action" value="update">

					<!-- submit and cancel button -->
					<button type="submit" class="btn btn-success">Submit</button>
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
			<form action="{{ route('admin.department_crud') }}" method="post" class="form-inline" id="DeleteModalForm">
				@csrf
				<div class="modal-header bg-danger">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
					<h5 class="modal-title" id="mediumModalLabel"><span class="fa fa-times"></span> Delete Department</h5>
				</div>
				<div class="modal-body">
					<div class="modal-wrapper">
						<div class="modal-icon">
							<i class="fa fa-times-circle"></i>
						</div>
						<div class="modal-text">
							<!-- <h4>Confirmation</h4> -->
							<!-- <p>This is a danger message.</p> -->
							<h5 class="DeleteConfirm"></h5>
						</div>
					</div>
					<br>
				</div>
				<div class="modal-footer">
					<!-- id and action -->
					<input type="hidden" id = "id" name="id">
					<input type="hidden" id = "action" name="action" value="delete">

					<!-- submit and cancel button -->
					<button type="submit" class="btn btn-success">Submit</button>
					<button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
				</div>
			</form>
		</div>
	</div>
</div>
<!-- end delete  -->

@endsection

