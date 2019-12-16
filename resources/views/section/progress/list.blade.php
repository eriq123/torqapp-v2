@extends('layouts.index')
@section('content')
<section role="main" class="content-body">
	@include('partials.role-header')
	<div class="row">
		<div class="col-md-12">

			<section class="panel panel-featured">
				<header class="panel-heading">
					<h2 class="panel-title">Request Tracker</h2>
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
						<table id="Table1" class="table table-hover " style="width:100%;">
							<thead>
								<tr>
									<th width="25%">ID</th>
									<th width="35%">Prepared by</th>
									<th width="40%">Actions</th>
								</tr>
							</thead>
							<tbody>
								@foreach($requests as $request)
								<tr>
									<td>{{$request->custom_id}}</td>
									<td>{{$request->section_head['name']}}</td>
									<td>
										<button
										id="view"
										data-id="{{$request->id}}"
										type="button"
										style="float: left; margin-right: 4px;" 
										class="btn btn-success">
										<span class="fa fa-eye">&nbsp;</span>View
									</button>
									@if($request->user_id == Auth::id())
									<form action="{{route('section.request_crud')}}" method="POST">
										@csrf
										<input type="hidden" name="id" value="{{$request->id}}">
										<button
										value="update_view"
										name="submit"
										type="submit" 
										style="float: left; margin-right: 4px;" 
										class="btn btn-primary"><span class="fa fa-edit">&nbsp;</span>Update
									</button>
								</form>
								<button 
								id="delete"
								data-id="{{$request->id}}"
								data-custom_id="{{$request->custom_id}}"
								type="button"
								class="btn btn-danger"><span class="fa fa-times">&nbsp;</span>Delete
							</button>
							@endif
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
@include('partials.requests.js')
<script>
	$(document).ready(function(){

// start delete
	$('#delete[data-id]').on('click', function() {
		$('#DeleteModal').modal('show');
		$('#DeleteModalForm')[0].reset();
		$('input#id').val($(this).data('id'));
		$('h5.DeleteConfirm').html('Are you sure you want to delete <b>'+$(this).data('custom_id')+'</b>?');
	}); 

// datatable 

	$('#Table1').DataTable({     
		"aoColumnDefs": [
		{ "bSortable": false, "aTargets": [ 2 ] }, 
		]
	});

});

</script>
@endsection

@section('modals')
@include('partials.modal.view_modal')
@include('partials.modal.logs_modal')

<!-- delete  -->
	<div class="modal fade" id="DeleteModal" tabindex="-1" role="dialog" aria-labelledby="mediumModalLabel" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<form action="{{ route('section.request_crud') }}" method="post" class="form-inline" id="DeleteModalForm">
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

@endsection

