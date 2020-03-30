@extends('layouts.index')
@section('content')
<section role="main" class="content-body">
	@include('partials.role-header')
	<div class="row">
		<div class="col-md-12">

			<section class="panel panel-featured">
				<header class="panel-heading">
					<h2 class="panel-title">APP</h2>
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
									<th>Status</th>
									<th>ID</th>
									<th>Course</th>
									<th>Fiscal Year</th>
									<th>Actions</th>
								</tr>
							</thead>
							<tbody>
							@foreach($apps as $app)
								<tr>
									<td>
										@if($app->status == "Open")
										<label class="label label-xs bg-warning">{{$app->status}}</label>
										@elseif($app->status == "Submitted")
										<label class="label label-xs bg-primary">{{$app->status}}</label>
										@elseif($app->status == "Approved")
										<label class="label label-xs bg-success">{{$app->status}}</label>
										@elseif($app->status == "Closed")
										<label class="label label-xs bg-dark">{{$app->status}}</label>
										@endif
									</td>
									<td>{{$app->custom_id}}</td>
									<td>{{$app->course}}</td>
									<td>{{$app->fiscal_year}}</td>
									<td>
										<form action = "{{route('admin.delete')}}" method="POST" onsubmit="return confirm('Are you sure you want to delete {{$app->custom_id}}?');">
											@csrf
											<input type="hidden" name="id" value="{{$app->id}}">
											<button 
												name="submit" 
												value="app" 
												class="btn btn-danger" 
												type="submit">
												<span class="fa fa-times">&nbsp;</span>Delete
											</button>
										</form>
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
@endsection

@section('js')
@include('partials.import.main',['import'=>"datatable",'type'=>'js'])

<script>
$(document).ready(function(){


// start datatable 1
$('#Table1').DataTable({     
	"aoColumnDefs": [
	{ "bSortable": false, "aTargets": [ 4 ] }, 
	]
});
// end datatable 1
});
</script>
@endsection

@section('modals')
@endsection

