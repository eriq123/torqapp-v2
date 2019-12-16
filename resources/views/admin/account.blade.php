@extends('layouts.index')
@section('content')
<section role="main" class="content-body">
	@include('partials.role-header')
	<div class="row">
		<div class="col-md-12">

			<section class="panel panel-featured">
				<header class="panel-heading">
					<h2 class="panel-title">Manage Accounts</h2>
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
									<th>Full Name</th>
									<th>Username</th>
									<th>Department</th>
									<th>Course</th>
									<th>Role</th>
									<th>Actions</th>
								</tr>
							</thead>
							<tbody>
								@foreach($users as $user)
								<tr>
									<td>{{ $user->full_name }}</td>
									<td>{{ $user->username }}</td>

									@if($user->department_id)
										<td>{{ $user->department->name }}</td>
									@else
										<td><em>N/A</em></td>
									@endif

									@if($user->course_id)
										<td>{{ $user->course->course_name }}</td>
									@else
										<td><em>N/A</em></td>
									@endif		

									<td>
										@if($user->roles->count() > 0)
											@foreach($user->roles as $role)
												{{$role->name}}
											@endforeach
										@else
											<em>N/A</em>
										@endif
									</td>
									<td>
									<!-- foreach the role -->
									@foreach($user->roles as $role)
										<!-- if user is not an admin -->
										@if($role->name != 'Admin')
											<form class="form-horizontal" method="post" action="{{ route('admin.account_actions') }}">
											@csrf
												<!-- user id -->
												<input type="hidden" name="id" value="{{$user->id}}">
												<!-- role id -->
												<input type="hidden" name="role" value="{{$role->id}}">

												<button
													value="PasswordReset"
													name="submit"
													type="submit"
													class="btn btn-primary btn-xs">Reset Password
												</button>

												<!-- if user is active or not -->
												@if($user->active == 1)
													<!-- action -->
													<input type="hidden" name="action" value="deactivate">
													<!-- button -->
													<button 
														value="deactivate" 
														name="submit" 
														type="submit" 
														class="btn btn-danger btn-xs">Deactivate Account
													</button>
												@else
													<!-- action -->
													<input type="hidden" name="action" value="activate">
													<!-- button -->
													<button 
														value="activate"
														name="submit" 
														type="submit" 
														class="btn btn-success btn-xs">Activate Account
													</button>
												@endif
												
												<!-- button to update -->
												<button 
													id="Update" 
													data-department="{{optional($user)->department_id}}"
													data-course="{{optional($user)->course_id}}"
													data-role="{{optional($role)->id}}"
													data-name = "{{$user->full_name}}"
													data-id="{{$user->id}}"
													type="button" 
													class="btn btn-warning btn-xs">Update User Info
												</button>
											</form>
										@endif
									@endforeach
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
	@include('partials.import.main',['import'=>"datatable",'type'=>"css"])
@endsection

@section('js')
@include('partials.import.main',['import'=>"datatable",'type'=>"js"])

<script>
//start document ready
$( document ).ready(function() {

// start Update
$('#Update[data-id]').on('click', function() {
	$('#UpdateModal').modal('show');
	$('#UpdateModalForm')[0].reset();
	$('input#name').val($(this).data('name'));
	$('select#department').val($(this).data('department'));
	$('select#course').val($(this).data('course'));
	$('select#role').val($(this).data('role'));
	$('input#old_role').val($(this).data('role'));
	$('input#id').val($(this).data('id'));
});
// end Update


// start datatable 1
$('#Table1').DataTable({     
	"aoColumnDefs": [
	{ "bSortable": false, "aTargets": [ 5 ] }, 
	]
});
// end datatable 1
});
// end document ready
</script>
@endsection
@section('modals')
<!-- add role  -->
<div class="modal fade" id="UpdateModal" tabindex="-1" role="dialog" aria-labelledby="mediumModalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<form action="{{ route('admin.account_actions') }}" method="post" id="UpdateModalForm">
				@csrf
				<div class="modal-header bg-success">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
					<h5 class="modal-title" id="mediumModalLabel"><span class="fa fa-plus"></span> Update User Info</h5>
				</div>
				<div class="modal-body">
                    <div class="row form-group">
						<div class="col col-md-3">
							<label for="sel1" class="col-md-4 col-form-label text-md-right">User: </label>
						</div>
						<div class="col-12 col-md-9">
							<input type="text" name="name" id="name" class = "form-control" readonly>
						</div>
					</div>
					<div class="row form-group">
						<div class="col col-md-3">
							<label for="sel1" class="col-md-4 col-form-label text-md-right">Department: </label>
						</div>
						<div class="col-12 col-md-9">
							<select name="department" class="form-control" id = "department">
								<option selected="selected"></option>
								@foreach($departments as $department)
									<option value="{{$department->id}}">{{ $department->name }}</option>
								@endforeach
							</select>
						</div>
					</div>
					<div class="row form-group">
						<div class="col col-md-3">
							<label for="sel1" class="col-md-4 col-form-label text-md-right">Course: </label>
						</div>
						<div class="col-12 col-md-9">
							<select name="course" class="form-control" id = "course">
								<option selected="selected"></option>
								@foreach($courses as $course)
									<option value="{{$course->id}}">{{ $course->course_name }}</option>
								@endforeach
							</select>
						</div>
					</div>
					<div class="row form-group">
						<div class="col col-md-3">
							<label for="sel1" class="col-md-4 col-form-label text-md-right">Role: </label>
						</div>
						<div class="col-12 col-md-9">
							<select name="role" class="form-control" id = "role">
								<option selected="selected"></option>
								@foreach($roles as $role)
									<option value="{{$role->id}}">{{ $role->name }}</option>
								@endforeach
							</select>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<!-- id and action -->
					<input type="hidden" id = "id" name="id">
					<input type="hidden" id = "old_role" name="old_role">

					<!-- submit and cancel button -->
					<button type="submit" name="submit" value="update" class="btn btn-success">Submit</button>
					<button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
				</div>
			</form>
		</div>
	</div>
</div>
<!-- end add role  -->
@endsection
