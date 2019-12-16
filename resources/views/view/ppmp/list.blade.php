@extends('layouts.index')
@section('content')
<section role="main" class="content-body">
	@include('partials.role-header')
	<div class="row">
		<div class="col-md-12">

			<section class="panel">
				<header class="panel-heading panel-heading-outline " >
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
						<!-- ppmp list -->
						<table id="Table1" class="table table-hover " style="width:100%;">
							<thead>
								<tr>
									<th>Status</th>
									<th>ID</th>
									<th>Course</th>
									<th>Prepared By</th>
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
										<form method = "GET" action="{{route('view.items_list',['type'=>$type,'id'=>$ppmp->id])}}">
											@csrf
											<input type="hidden" name="id" value="{{$ppmp->id}}">
											<button
											value="open"
											name="submit"
											type="submit"
											class="btn btn-success ">
											<span class="fa fa-folder-open"></span> Open
										</button>
									</form>
								</td>
							</tr>
							@endforeach
						</tbody>
					</table>
					<!-- end ppmp list -->
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

@section('modals')

@endsection

