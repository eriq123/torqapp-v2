@extends('layouts.index')
@section('content')
<section role="main" class="content-body">
	@include('partials.role-header')
	<div class="row">
		<div class="col-md-12">

			<section class="panel panel-featured">
				<header class="panel-heading">
					<h2 class="panel-title">Requests</h2>
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
									<th>ID</th>
									<th>Prepared by</th>
									<th>Date</th>
									<th>Action</th>
								</tr>
							</thead>
							<tbody>
							@foreach($requests as $request)
							<tr>
								<td>{{$request->custom_id}}</td>
								<td>{{$request->section_head['name']}}</td>
								<td>{{$request->date}}</td>
								<td>
									<form action = "{{route('admin.delete')}}" method="POST" onsubmit="return confirm('Are you sure you want to delete {{$request->custom_id}}?');">
										@csrf
										<input type="hidden" name="id" value="{{$request->id}}">
										<button 
											name="submit" 
											value="request" 
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
	{ "bSortable": false, "aTargets": [ 3 ] }, 
	]
});
// end datatable 1
});
</script>
@endsection

@section('modals')
@endsection

