<!-- CreatePpmp  -->
<div class="modal fade" id="CreatePpmp" tabindex="-1" role="dialog" aria-labelledby="mediumModalLabel" aria-hidden="true">
	<div class="modal-dialog " role="document">
		<div class="modal-content">
			<form action="{{ route('section.ppmp_crud') }}" method="post" id="CreatePpmpForm">
				@csrf
				<div class="modal-header bg-success">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
					<h5 class="modal-title"><span class="fa fa-plus"></span> New PPMP</h5>
				</div>
				<div class="modal-body">
					<div class="row form-group">
						<div class="col col-md-3">
							<label for="sel1" class="col-12 col-form-label text-md-right">Prepared by </label>
						</div>
						<div class="col-12 col-md-9">
							<input type="text" name="create_name" id="create_name" class = "form-control" value="{{Auth::user()->full_name}}" required>
						</div>
					</div>
					<div class="row form-group">
						<div class="col col-md-3">
							<label for="sel1" class="col-12 col-form-label text-md-right">End User </label>
						</div>
						<div class="col-12 col-md-9">
							<input type="text" name="create_course" id="create_course" class = "form-control" value="{{Auth::user()->course->course_name}}" required>
						</div>
					</div>
					<div class="row form-group">
						<div class="col col-md-3">
							<label for="sel1" class="col-12 col-form-label text-md-right">For </label>
						</div>
						<div class="col-12 col-md-9">
							<select name = "create_type" id = "create_type" class = "form-control">
								<option value = "Supplies/Equipment" selected = "selected">Supplies/Equipment</option>
								<option value = "Supplemental">Supplemental</option>
							</select>
						</div>
					</div>
					<div class="row form-group">
						<div class="col col-md-3">
							<label for="sel1" class="col-12 col-form-label text-md-right">Fiscal Year </label>
						</div>
						<div class="col-12 col-md-9">
							<input type="text" name="create_fiscal_year" id="create_fiscal_year" class = "form-control" placeholder="Fiscal Year" required>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<!-- submit and cancel button -->
					<button type="submit" class="btn btn-success" name="submit" value="add">Submit</button>
					<button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
				</div>
			</form>
		</div>
	</div>
</div>
<!-- end CreatePpmp  -->

