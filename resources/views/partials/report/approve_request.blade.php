@if($role == "ADAA")

	<section class="panel panel-featured">
		<header class="panel-heading">
			<h2 class="panel-title">Request to Approve</h2>
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
						@foreach($requests as $request)

						@endforeach
					</tbody>
				</table>
			</div>
		</div>
	</section>


@endif