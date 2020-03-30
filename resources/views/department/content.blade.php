@extends('layouts.index')
@section('content')
<section role="main" class="content-body">
	@include('partials.role-header')
	<div class="row">
		<div class="col-md-12">

			<section class="panel panel-featured">
				<header class="panel-heading">
					<h2 class="panel-title">Budget Allocation for {{Auth::user()->department->department_name}}</h2>
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
									<th>Course</th>
									<th>Supplies</th>
									<th>Equipment</th>
									<th>Supplemental</th>
									<th>Total</th>
								</tr>
							</thead>
							<tbody>
							@foreach($courses as $course)
							<tr>
								<td>{{$course->course_name}}</td>
								<td>{{number_format($course->supplies , 2)}}</td>
								<td>{{number_format($course->equipment , 2)}}</td>
								<td>{{number_format($course->supplemental , 2)}}</td>
								<td>{{number_format(($course->supplies + $course->equipment + $course->supplemental) , 2)}}</td>
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

		var table1 = $('#Table1').DataTable();
			table1.order([4,'desc']).draw();

	});
</script>
@endsection


