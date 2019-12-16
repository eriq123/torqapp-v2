@extends('layouts.index')
@section('content')
<section role="main" class="content-body">
	@include('partials.role-header')
	<div class="row">
		<div class="col-md-10 col-md-offset-1">
			<section class="panel panel-featured">
				<header class="panel-heading">
					<h2 class="panel-title">Please select which APP will be attached to your request</h2>
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
									<th>Type</th>
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
									<td>{{$app->type}}</td>
									<td><label class="label label-xs bg-success">{{$app->status}}</label></td>
									<td>{{$app->custom_id}}</td>
									<td>{{$app->course}}</td>
									<td>{{$app->fiscal_year}}</td>
									<td>
										<form action="{{route('section.request_add',['id'=>$app->id])}}" method="GET">
										@csrf
											<button 
												type="submit" 
												class="btn btn-success">
												<span class="fa fa-check">&nbsp;</span>Select
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
	{ "bSortable": false, "aTargets": [ 5 ] }, 
	]
});
// end datatable 1
});
</script>
@endsection

