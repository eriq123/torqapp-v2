<section class="panel panel-featured">
	<header class="panel-heading">
	@if($role == "ADAA" || $role == "Department Head" || $role == "Campus Director")
		<h2 class="panel-title">Requests to approve</h2>
	@elseif($role == "BAC Secretary" || $role == "Procurement" || $role == "Supplies")
		<h2 class="panel-title">Requests at your department</h2>
	@endif
	</header>
	<div class="panel-body" style="display: block;">

		<div class="table-responsive">
			<table id="TableRequest" class="table table-hover" style="width:100%;">
				<thead>
					<tr>
						<th>Type</th>
						<th>Current Location</th>
						<th>ID</th>
						<th>Prepared By</th>
						<th>Date</th>
					</tr>
				</thead>
				<tbody>
					@foreach($requests as $request)
					<tr>
						<td>{{$request->app->type}}</td>
						<td>{{$request->status}}</td>
						<td>{{$request->custom_id}}</td>
						<td>{{$request->section_head['name']}}</td>
						<td>{{$request->date}}</td>
					</tr>
					@endforeach
				</tbody>
			</table>
		</div>
	</div>
</section>


