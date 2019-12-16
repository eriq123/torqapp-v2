@extends('layouts.index')
@section('content')
<section role="main" class="content-body">
	@include('partials.role-header')
	<div class="row">
		<div class="col-md-12">

			<section class="panel panel-featured">
				<header class="panel-heading">
					<h2 class="panel-title">{{$app_type}} APP</h2>
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
						<!-- table1 -->
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
										<form method="POST" action="{{route('app.crud')}}">
											@csrf
											<input type="hidden" name="id" value="{{$app->id}}">
											@if(Auth::user()->RoleName == "BAC Secretary")
												@if(!$app->prepared['signature'])
												<button
												style="float: left;margin-right: 4px;"
												value="sign"
												name="submit"
												type="submit"
												class="btn btn-warning"><span class="fas fa-pen-alt"></span> Sign
												</button>
												@endif
											@elseif(Auth::user()->RoleName == "BAC Chairperson")
												@if($app->prepared['signature'])
													@if(!$app->recommended['signature'])
													<button
													style="float: left;margin-right: 4px;"
													value="sign"
													name="submit"
													type="submit"
													class="btn btn-warning"><span class="fas fa-pen-alt"></span> Sign
													</button>
													@endif
												@endif
											@elseif(Auth::user()->RoleName == "Campus Director")
												@if($app->prepared['signature'])
													@if($app->recommended['signature'])
														@if(!$app->approved['signature'])
														<button
														style="float: left;margin-right: 4px;"
														value="sign"
														name="submit"
														type="submit"
														class="btn btn-warning"><span class="fas fa-pen-alt"></span> Sign
														</button>
														@endif
													@endif
												@endif
											@endif
											<button
											style="float: left;margin-right: 4px;"
											value="view"
											name="submit"
											type="submit"
											class="btn btn-success"><span class="fa fa-eye"></span> View
											</button>
										</form>
										<form method="POST" action="{{route('app.crud')}}" target="_blank">
										@csrf
											<input type="hidden" name="id" value="{{$app->id}}">
											<button
											value="print"
											name="submit"
											type="submit"
											class="btn btn-primary"><span class="fa fa-print"></span> Print
											</button>
										</form>
									</td>
								</tr>
								@endforeach	
							</tbody>
						</table>
						<!-- end table1 -->
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

