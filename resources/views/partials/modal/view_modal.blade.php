<div class="modal fade" id="ViewModal" tabindex="-1" role="dialog" aria-labelledby="mediumModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document" id="modal-larger-class">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
				<h5 class="modal-title view"></h5>
			</div>
			<div class='modal-body'>
				<div class="printview-form"></div>

				<div class="tabs" style="margin-bottom: 5px;">
					<ul class="nav nav-tabs tabs-primary">
						<li class = "active" id="li_status_tab">
							<a href="#request_status_tab" data-toggle="tab">Status</a>
						</li>
						<li id="li_items_tab">
							<a href="#request_items_tab" data-toggle="tab">Request Items</a>
						</li>
					</ul>
					<div class="tab-content">
						<div id="request_status_tab" class="tab-pane active">

						</div>
						<div id="request_items_tab" class="tab-pane">
							<form class="form-horizontal">
								<div class="table-responsive">
									<table id="Table2" class="table table-hover " style="width:100%;">
										<thead>
											<tr>
												<th>Status</th>
												<th>Code</th>
												<th>Category</th>
												<th>Description</th>
												<th>Quantity</th>
												<!-- <th>Cost</th> -->
												<!-- <th>Total</th> -->
												<th>Schedule</th>
												<th>Actions</th>
											</tr>
										</thead>
										<tbody>

										</tbody>
									</table>
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>