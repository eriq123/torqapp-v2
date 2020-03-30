@extends('layouts.index')
@section('content')
<section role="main" class="content-body">
	@include('partials.role-header')
	<div class="row">
		<div class="col-md-12">

			<section class="panel panel-featured">
				<header class="panel-heading">
					<h2 class="panel-title">Submitted PPMP</h2>
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
						<table id="Table1" class="table table-hover" style="width:100%;">
							<thead>
								<tr>
									<th>Type</th>
									<th>Status</th>
									<th>ID</th>
									<th>Course</th>
									<th>Prepared By</th>
									<th>Fiscal Year</th>
								</tr>
							</thead>
							<tbody>
								@foreach($ppmps as $ppmp)
								<tr>
									<td>{{$ppmp->type}}</td>
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
								</tr>
								@endforeach
							</tbody>
						</table>
					</div>
				</div>
			</section>

			<hr>

			<section class="panel panel-featured">
				<header class="panel-heading">
					<h2 class="panel-title">APP that needs your signature</h2>
				</header>
				<div class="panel-body" style="display: block;">

					<div class="table-responsive">
						<table id="Table2" class="table table-hover" style="width:100%;">
							<thead>
								<tr>
									<th>Type</th>
									<th>Status</th>
									<th>ID</th>
									<th>Course</th>
									<th>Prepared By</th>
									<th>Fiscal Year</th>
								</tr>
							</thead>
							<tbody>
								@foreach($apps as $app)
								<tr>
									<td>{{$app->type}}</td>
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
									<td>{{$app->prepared['name']}}</td>
									<td>{{$app->fiscal_year}}</td>
								</tr>
								@endforeach
							</tbody>
						</table>
					</div>
				</div>
			</section>

			<hr>

			@include('partials.report.approve_request',['role'=>Auth::user()->RoleName])
			
		</div>
	</div>		
</section>
@endsection
@section('css')
@include('partials.import.main',['import'=>"datatable",'type'=>'css'])
@endsection

@section('js')
@include('partials.import.main',['import'=>"datatable",'type'=>'js'])
@include('partials.report.TableRequest')

<script>
	$(document).ready(function(){

		$('#Table1').DataTable({     
			"aoColumnDefs": [
			{ "bSortable": false, "aTargets": [ 1 ] }, 
			]
		});

		$('#Table2').DataTable({     
			"aoColumnDefs": [
			{ "bSortable": false, "aTargets": [ 1 ] }, 
			]
		});
	});
</script>
@endsection


