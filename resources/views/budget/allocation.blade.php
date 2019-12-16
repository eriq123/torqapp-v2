@extends('layouts.index')
@section('content')
<section role="main" class="content-body">
	@include('partials.role-header')
	<div class="row">
		<div class="col-md-12">

			<section class="panel panel-featured">
				<header class="panel-heading">
					<h2 class="panel-title">Budget Allocation</h2>
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
						<!-- edit department -->
						<table id="Table1" class="table table-hover table-bordered" style="width:100%;">
							<thead>
								<tr>
									<th>Department</th>
									<th>Course</th>
									<th>Supplies</th>
									<th>Equipment</th>
									<th>Supplemental</th>
									<th>Actions</th>
								</tr>
							</thead>
							<tbody>
								@foreach($courses as $course)
								<tr>
									<td>{{$course->department->name}}</td>
									<td>{{$course->course_name}}</td>
									<td>{{number_format($course->supplies,2)}}</td>
									<td>{{number_format($course->equipment,2)}}</td>
									<td>{{number_format($course->supplemental,2)}}</td>
									<td>
										<button 
											id="Allocate" 
											type="button"
											data-id = "{{$course->id}}" 
											data-department = "{{$course->department->name}}" 
											data-course = "{{$course->course_name}}" 
											class="btn btn-success btn-xs"><i class="fa fa-plus"></i> Allocate
										</button>
									</td>
								</tr>
								@endforeach
							</tbody>
						</table>
						<!-- end edit department -->
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

@include('partials.import.main',['import'=>"cleave_js"])
@include('partials.import.main',['import'=>"datatable",'type'=>"js"])

<script>
//start document ready
$( document ).ready(function() {

// format input
var cleave = new Cleave('.input_format_1', {
    numeral: true,
    numeralThousandsGroupStyle: 'thousand'
});

var cleave = new Cleave('.input_format_2', {
    numeral: true,
    numeralThousandsGroupStyle: 'thousand'
});

var cleave = new Cleave('.input_format_3', {
    numeral: true,
    numeralThousandsGroupStyle: 'thousand'
});
// end format input

// start Allocate
$('#Allocate[data-id]').on('click', function() {
	$('#AllocateModal').modal('show');
	$('#AllocateModalForm')[0].reset();
	$('input#id').val($(this).data('id'));
	$('input#department').val($(this).data('department'));
	$('input#course').val($(this).data('course'));
});
// end Allocate

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
<!-- allocate  -->
<div class="modal fade" id="AllocateModal" tabindex="-1" role="dialog" aria-labelledby="mediumModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<form action="{{ route('budget.allocation_actions') }}" method="post" id="AllocateModalForm">
				@csrf
				<div class="modal-header bg-success">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
					<h5 class="modal-title" id="mediumModalLabel"><span class="fa fa-plus"></span> Allocate Budget</h5>
				</div>
				<div class="modal-body">
                    <div class="row form-group">
						<div class="col col-md-3">
							<label for="sel1" class="col-12 col-form-label text-md-right">Department </label>
						</div>
						<div class="col-12 col-md-9">
							<input type="text" name="department" id="department" class = "form-control" readonly>
						</div>
					</div>
                    <div class="row form-group">
						<div class="col col-md-3">
							<label for="sel1" class="col-12 col-form-label text-md-right">Course </label>
						</div>
						<div class="col-12 col-md-9">
							<input type="text" name="course" id="course" class = "form-control" readonly>
						</div>
					</div>
					<div class="row form-group">
						<div class="col col-md-3">
							<label for="sel1" class="col-12 col-form-label text-md-right">Supplies Budget <span style="color: red;">*</span> </label>
						</div>
						<div class="col-12 col-md-9">
							<input type="text" name="supplies" id="supplies" class = "form-control input_format_1" placeholder="00.00" value="0" required>
						</div>
					</div>
					<div class="row form-group">
						<div class="col col-md-3">
							<label for="sel1" class="col-12 col-form-label text-md-right">Equipment Budget <span style="color: red;">*</span> </label>
						</div>
						<div class="col-12 col-md-9">
							<input type="text" name="equipment" id="equipment" class = "form-control input_format_2" placeholder="00.00" value="0" required>
						</div>
					</div>
					<div class="row form-group">
						<div class="col col-md-3">
							<label for="sel1" class="col-12 col-form-label text-md-right">Supplemental Budget <span style="color: red;">*</span> </label>
						</div>
						<div class="col-12 col-md-9">
							<input type="text" name="supplemental" id="supplemental" class = "form-control input_format_3" placeholder="00.00" value="0" required>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<!-- id and action -->
					<input type="hidden" id = "id" name="id">
					<input type="hidden" id = "action" name="action" value="allocate">

					<!-- submit and cancel button -->
					<button type="submit" class="btn btn-success">Submit</button>
					<button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
				</div>
			</form>
		</div>
	</div>
</div>
<!-- end allocate  -->
@endsection

