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
									@if($request->status == Auth::user()->role_name)
										<form action="{{route('requests.crud')}}" method="POST">
										@csrf
											<input type="hidden" name="id" value="{{$request->id}}">
											@if($request->status == "Department Head" and $request->department_head['id'] == Auth::id())
												<button
													value="department_approve"
													name="submit"
													type="submit" 
													style="float: left; margin-right: 4px;" 
													class="btn btn-primary"><span class="fa fa-check">&nbsp;</span>Recommending Approve
												</button>
												<button
													data-id="{{$request->id}}"
													id="show_comment_modal"
													type="button" 
													style="float: left; margin-right: 4px;" 
													class="btn btn-danger"><span class="fa fa-times">&nbsp;</span>Needs Revision
												</button>
											@elseif($request->status == "ADAA" and $request->adaa['id'] == Auth::id())
												<button
													value="adaa_approve"
													name="submit"
													type="submit" 
													style="float: left; margin-right: 4px;" 
													class="btn btn-primary"><span class="fa fa-check">&nbsp;</span>Noted
												</button>
												<button
													data-id="{{$request->id}}"
													id="show_comment_modal"
													type="button" 
													style="float: left; margin-right: 4px;" 
													class="btn btn-danger"><span class="fa fa-times">&nbsp;</span>Needs Revision
												</button>
											@elseif($request->status == "Campus Director" and $request->campus_director['id'] == Auth::id())
												<button
													value="campus_director_approve"
													name="submit"
													type="submit" 
													style="float: left; margin-right: 4px;" 
													class="btn btn-primary"><span class="fa fa-check">&nbsp;</span>Approve
												</button>
												<button
													data-id="{{$request->id}}"
													id="show_comment_modal"
													type="button" 
													style="float: left; margin-right: 4px;" 
													class="btn btn-danger"><span class="fa fa-times">&nbsp;</span>Needs Revision
												</button>
											@elseif($request->status == "BAC Secretary")
												<button
													value="bac_sec_transfer"
													name="submit"
													type="submit" 
													style="float: left; margin-right: 4px;" 
													class="btn btn-primary"><span class="fa fa-check">&nbsp;</span>Transfer
												</button>
											@elseif($request->status == "Procurement")
												<button
													value="proc_transfer"
													name="submit"
													type="submit" 
													style="float: left; margin-right: 4px;" 
													class="btn btn-primary"><span class="fa fa-check">&nbsp;</span>Transfer
												</button>
											@endif
										</form>
									@endif

									@if($request->status == Auth::user()->role_name)
										@if($request->status == "Supplies" or $request->status == "Section Head")
											<form action="{{route('requests.supplies_view',['id'=>$request->id])}}" method="GET">
											@csrf
												<button
													value="supplies_view"
													name="submit"
													type="submit" 
													style="float: left; margin-right: 4px;" 
													class="btn btn-primary"><span class="fa fa-check">&nbsp;</span>Transfer
												</button>
											</form>
										@endif
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

// start comment
	$('#show_comment_modal[data-id]').on('click', function() {
		$('#CommentModal').modal('show');
		$('#request_id').val($(this).data('id'));
	});

// datatables

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

<!-- comment modal -->
	<div class="modal fade" id="CommentModal" tabindex="-1" role="dialog" aria-labelledby="mediumModalLabel" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<form action="{{ route('requests.crud') }}" method="post" class="form-horizontal" id="CommentModalForm">
					@csrf
					<div class="modal-header bg-danger">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span><span class="sr-only">Close</span>
						</button>
						<h5 class="modal-title" id="mediumModalLabel">Comment</h5>
					</div>
					<div class="modal-body">
						<p>Please enter a comment below:</p>
						<textarea name="comment" id="comment" class="form-control" rows="5"></textarea>

					</div>
					<div class="modal-footer">
						<!-- id and action -->
						<input type="hidden" id = "request_id" name="id">

						<!-- submit and cancel button -->
						<button type="submit" class="btn btn-success" name = "submit" value="needs_revision">Submit</button>
						<button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
					</div>
				</form>
			</div>
		</div>
	</div>

@endsection

