@extends('layouts.index')
@section('content')
<section role="main" class="content-body">
	@include('partials.role-header')
	<form action="{{route('section.request_crud')}}" method="POST" enctype="multipart/form-data">
		@csrf
		<div class="row">
			<div class="panel-body col-md-8 col-md-offset-2" style="padding: 0 0 0 0;">
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

				<img src="{{asset('assets/images/request_sample_header2.png')}}" style="width: 100%;">

				<div class="row">
					<div class="col-md-8"></div>
					<div class="col-md-4">
						<input type="text" class="form-control" name = "RequestDate" id="RequestDate" autocomplete="off" placeholder="date" required>
					</div>
				</div>

				<div class="row">
					<div class="col-md-4">
						<select name="director_id" class = "form-control{{ $errors->has('director_id') ? ' is-invalid' : '' }}" required class="form-control" id = "director_id">
							@foreach($directors as $director)
							<option value="{{$director->id}}">{{ $director->full_name }}</option>
							@endforeach
						</select>
						<input type="text" name="director_role" class="form-control" value="Campus Director">
					</div>
				</div>
				<br>
				<div class="row">
					<div class="col-md-6 col-md-offset-3">
						<div class="input-group">
							<span class="input-group-addon">Thru: </span>
							<select name="adaa_id" class = "form-control{{ $errors->has('adaa_id') ? ' is-invalid' : '' }}" required class="form-control" id = "adaa_id" style="position: static!important;">
								@foreach($adaas as $adaa)
								<option value="{{$adaa->id}}">{{ $adaa->full_name }}</option>
								@endforeach
							</select>
						</div>
						<input type="text" name="adaa_role" class="form-control" value="Assistant Director for Academic Affairs">
					</div>
				</div>
				<br>

				<div class="document-editor">
					<div class="toolbar-container"></div>
					<div class="content-container">
						<div id="editor"></div>
					</div>
				</div>

				<br>
				<div class="row">
					<div class="col-md-6">
						<img src="{{Auth::user()->signature}}" height="19"><br>
						<input type="text" name="sh_name" class="form-control" value="{{Auth::user()->full_name}}">
						<input type="text" name="sh_role" class="form-control" value="Section Head">
						<br>
						<select name="department_id" class = "form-control{{ $errors->has('department_id') ? ' is-invalid' : '' }}"  class="form-control" id = "department_id">
							@foreach($departments as $department)
							<option value="{{$department->id}}">{{ $department->full_name }}</option>
							@endforeach
						</select>
						<input type="text" name="department_role" class="form-control" value="Department Head">
					</div>
				</div>
				<br>
			</div>
		</div>
		<br>
		<div class="row">
			<div class="panel-body col-md-6 col-md-offset-3">
				<div class="well">
					<span style="float: left;"><b>Attachment for additional specifications: &nbsp;</b></span>
					<input type="file" class="form-control-file" name="attachment">
				</div>
				<a data-toggle="modal" data-target="#EditModal" href="#" role="button" class="mb-xs btn btn-dark"><span class = "fa fa-list">&nbsp;</span>Request Items</a>

				<input type="hidden" name="Rcontent" id="Rcontent">
				<input type="hidden" name="items" id="items">
				<input type="hidden" name="app_id" id="app_id" value="{{$app->id}}">
				<button class="mb-xs btn btn-success" type="submit" id = "submit" name="submit" value="add"><span class = "fa fa-send">&nbsp;</span>Send</button>
			</div>
		</div>
		<br>
	</form>
	<br>
</section>
@endsection
@section('css')
@include('partials.import.main',['import'=>"datatable",'type'=>'css'])
@include('partials.import.main',['import'=>"ckeditor",'type'=>'css'])
@include('partials.import.main',['import'=>"datepicker",'type'=>'css'])

@endsection
@section('js')
@include('partials.import.main',['import'=>"datatable",'type'=>'js'])
@include('partials.import.main',['import'=>"ckeditor",'type'=>'js'])
@include('partials.import.main',['import'=>"datepicker",'type'=>'js'])

<script>
	$(document).ready(function(){
		$('#EditModal').modal('show');

		var editor = CKEDITOR.replace( 'editor' );
		
		document.querySelector( '#submit' ).addEventListener( 'click', () => {
			document.querySelector( '#Rcontent' ).value = editor.getData();
		});
		
		// var html = "asdasd";
		// CKEDITOR.instances['editor'].setData(html);

		$(function() {
			$( "#RequestDate" ).datepicker({
				dateFormat: "MM d, yy",
				changeMonth: true,
				changeYear: true,
			});
		});

		$("#parent").click(function() {
			$(".child").prop("checked", this.checked);
		});

		$('.child').click(function() {
			if ($('.child:checked').length == $('.child').length) {
				$('#parent').prop('checked', true);
			} else {
				$('#parent').prop('checked', false);
			}
		});

		$("#select_item").click(function() {
			id = [];
			$('.child:checked').each(function(index){
				id.push($(this).val());
			});	

			$('#id').val(id);
			$('#items').val(id);
			$('#EditModal').modal('hide');
		});

		$('#Table1').DataTable({     
			"aoColumnDefs": [
			{ "bSortable": false, "aTargets": [ 0 ] }, 
			]
		});

	});
</script>
@endsection
@section('modals')

<!-- edit  -->
<div class="modal fade" id="EditModal" tabindex="-1" role="dialog" aria-labelledby="mediumModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header bg-primary">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span><span class="sr-only">Close</span>
				</button>
				<h5 class="modal-title" id="mediumModalLabel">{{$app->custom_id}}</h5>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="col col-md-12">
						<form action="{{ route('adaa.items_crud') }}" method="post" class="form-horizontal" id="EditModalForm">
							@csrf
							<input type="hidden" name="id" id="id">
							<button 
							id="select_item" 
							value="select_item" 
							name="submit" 
							type="button" 
							class="btn btn-success"><span class="fa fa-check"></span> Select
						</button>
					</form>
				</div>
			</div>
			<br>
			<form class="form-horizontal" style="border-top: solid;">
				<br>
				<div class="table-responsive">
					<table id="Table1" class="table table-hover " style="width:100%;">
						<thead>
							<tr>
								<th>
									<input type="checkbox" id="parent" value="">
								</th>
								<th>Code</th>
								<th>Category</th>
								<th>Description</th>
								<th>Quantity</th>
								<th>Cost</th>
								<th>Total</th>
								<th>Schedule</th>
							</tr>
						</thead>
						<tbody>
							@foreach($app->item as $item)
								@if(!$item->requested)
								<tr>
									<td>
										<input type="checkbox" class="child" value="{{$item->id}}">
									</td>
									<td>{{$item->code}}</td>
									<td>{{$item->category}}</td>
									<td>{{$item->description}}</td>
									<td>{{$item->quantity}} {{$item->unit}}</td>
									<td>{{number_format($item->cost,2)}}</td>
									<td>{{number_format($item->total,2)}}</td>
									<td>{{$item->schedule}}</td>
								</tr>
								@endif
							@endforeach
						</tbody>
					</table>
				</div>
			</form>
		</div>	
	</div>
</div>
</div>
<!-- end edit  -->
@endsection
