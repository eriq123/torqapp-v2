<script>
$(document).ready(function(){

// view modal
$('#view[data-id]').on('click', function() {
	$.ajax({
		type: "POST",
		url: "{{route('requests.modal_view')}}",
		data: {
			submit: "progress_view_status",
			id: $(this).data('id'),
		},
		success: function(data){
			console.log(data.req);
			console.log(data.items);
			console.log(data.custom_id);
			console.log(data.progress);
			console.log(data.last_progress);
			console.log(data.req);
			
			var title = data.custom_id + " with " + data.app_custom_id;

			var title = "<form action='{{route('app.crud')}}' method='POST' target='_blank'>";
				title += "<input type = 'hidden' name = '_token' value='{{ csrf_token() }}' >";
				title += "<input type='hidden' name='id' value='"+data.app.id+"'>";
				title += data.custom_id+ " with ";
				title += "<button ";
				title += "value='view'";
				title += "name='submit'";
				title += "type='submit'";
				title += "class='btn btn-default'>"+data.app_custom_id;
				title += "</button>";
				title += "</form>";

			$('h5.modal-title.view').html(title);

			var modal_form_buttons = "<form action='{{route('requests.progress_crud')}}' method='POST' target='_blank'>";
				modal_form_buttons += "<input type = 'hidden' name = '_token' value='{{ csrf_token() }}' >";
				modal_form_buttons += "<input type='hidden' name='id' value='"+data.req.id+"'>";
				modal_form_buttons += "<button ";
				modal_form_buttons += "style='float: left; margin-right: 4px;'";
				modal_form_buttons += "value='print'";
				modal_form_buttons += "name='submit'";
				modal_form_buttons += "type='submit'";
				modal_form_buttons += "class='btn btn-primary'><span class='fa fa-print'>&nbsp;</span>Print View";
				modal_form_buttons += "</button>";
				modal_form_buttons += "</form>";

			if (data.req.attachment == null) {
				
			}else{
				modal_form_buttons += "<form action='{{route('requests.progress_crud')}}' method='POST'>";
				modal_form_buttons += "<input type = 'hidden' name = '_token' value='{{ csrf_token() }}' >";
				modal_form_buttons += "<input type='hidden' name='id' value='"+data.req.id+"'>";
				modal_form_buttons += "<button ";
				modal_form_buttons += "style='float: left; margin-right: 4px;'";
				modal_form_buttons += "value='download'";
				modal_form_buttons += "name='submit'";
				modal_form_buttons += "type='submit'";
				modal_form_buttons += "class='btn btn-success'><span class='fa fa-download'>&nbsp;</span>Download Attachment";
				modal_form_buttons += "</button>";
				modal_form_buttons += "</form>";
			}

			modal_form_buttons += "<br><hr>";

			var status_tab = "<form class='form-horizontal'>";
			status_tab += "<div class='row'>";
			status_tab += "<div class='col-md-12'>";
			status_tab += "<div class='btn-group btn-group-justified'>";
			status_tab += justified_button(data.req.status, data.last_progress.status);
			status_tab += "</div>";

			status_tab += "<div class = 'well'>";
			status_tab += "<ul>";

			var progress = JSON.parse(JSON.stringify(data.progress).replace(/null/g, '" "'));
			$.each(progress, function( k, v ) {
				status_tab += "<li>";
				if (v.status == "sent") {
					status_tab += "Request was " + v.status + " to <b>" + v.office + "</b> at " + v.created_at;
				}else if (v.status == "needs revision") {
					status_tab += "Request " + v.status + ", from <b>" + v.office + "</b> at " + v.created_at;
				}else if (v.status == "closed") {
					status_tab += "Request was " + v.status + " by <b>" + v.office + "</b> at " + v.created_at;
				}else {
					status_tab += v.status + " - " + v.created_at;
				}
				status_tab += "</li>";
			});

			status_tab += "</ul>";
			status_tab += "</div>";
			status_tab += "</div>";
			status_tab += "</div>";
			status_tab += "</form>";

			table2.clear().draw();
			var items_data = JSON.parse(JSON.stringify(data.items).replace(/null/g, '" "'));

			$.each(items_data, function( k, v ) {
				var table2_data = [];

				if (v.status == "To be fulfilled") {
					table2_data.push("<label class='label label-dark'>"+v.status+"</label>");
				}else if(v.status == "Partially fulfilled") {
					table2_data.push("<label class='label label-primary'>"+v.status+"</label>");
				}else if (v.status == "Fulfilled") {
					table2_data.push("<label class='label label-success'>"+v.status+"</label>");
				}else{
					table2_data.push("<label class='label label-warning'>"+v.status+"</label>");
				}

				table2_data.push(v.item.code);
				table2_data.push(v.item.category);
				table2_data.push(v.item.description);
				table2_data.push(v.quantity + " / " + v.item.quantity + " "+ v.item.unit);
				// table2_data.push(v.item.cost);
				// table2_data.push(v.item.total);
				table2_data.push(v.item.schedule);

				var view_modal_logs_btn = "<button ";
				view_modal_logs_btn +=	"data-id='"+v.id+"' ";
				view_modal_logs_btn +=	"id='logs_modal_btn' ";
				view_modal_logs_btn +=	"type='button' ";
				// view_modal_logs_btn +=	"style='float: left; margin-right: 4px;' ";
				view_modal_logs_btn +=	"class='btn btn-dark'><span class='fa fa-file-text-o'>&nbsp;</span>Logs";
				view_modal_logs_btn += "</button>";

				table2_data.push(view_modal_logs_btn);

				table2.row.add(table2_data).draw().nodes().to$();

			});	

			$('div.printview-form').html(modal_form_buttons);
			$('div#request_status_tab').html(status_tab);
			$('#ViewModal').modal('show');
		},
		errors: function (data){
			alert(data);
		},
	});
}); 

// justified_buttons
function justified_button(status,lp_status){
	if (status == "Section Head") {
		var buttons = "<a class='btn btn-success' role='button'>Department Head</a>";
		buttons += "<a class='btn btn-success' role='button'>ADAA</a>";
		buttons += "<a class='btn btn-success' role='button'>Campus Director</a>";
		buttons += "<a class='btn btn-success' role='button'>BAC</a>";
		buttons += "<a class='btn btn-success' role='button'>Procurement</a>";
		buttons += "<a class='btn btn-success' role='button'>Supplies</a>";

		buttons += "<a class='btn btn-success' role='button'>Section Head</a>";
		
	} else if (status == "Supplies") {
		var buttons = "<a class='btn btn-success' role='button'>Department Head</a>";
		buttons += "<a class='btn btn-success' role='button'>ADAA</a>";
		buttons += "<a class='btn btn-success' role='button'>Campus Director</a>";
		buttons += "<a class='btn btn-success' role='button'>BAC</a>";
		buttons += "<a class='btn btn-success' role='button'>Procurement</a>";

		if (lp_status == "sent") {
			buttons += "<a class='btn btn-success' role='button'>Supplies</a>";
		} else {
			buttons += "<a class='btn btn-danger' role='button'>Supplies</a>";
		}

		buttons += "<a class='btn btn-dark' role='button'>Section Head</a>";

	} else if (status == "Procurement") {
		var buttons = "<a class='btn btn-success' role='button'>Department Head</a>";
		buttons += "<a class='btn btn-success' role='button'>ADAA</a>";
		buttons += "<a class='btn btn-success' role='button'>Campus Director</a>";
		buttons += "<a class='btn btn-success' role='button'>BAC</a>";

		if (lp_status == "sent") {
			buttons += "<a class='btn btn-success' role='button'>Procurement</a>";
		} else {
			buttons += "<a class='btn btn-danger' role='button'>Procurement</a>";
		}

		buttons += "<a class='btn btn-dark' role='button'>Supplies</a>";
		buttons += "<a class='btn btn-dark' role='button'>Section Head</a>";

	} else if (status == "BAC Secretary") {
		var buttons = "<a class='btn btn-success' role='button'>Department Head</a>";
		buttons += "<a class='btn btn-success' role='button'>ADAA</a>";
		buttons += "<a class='btn btn-success' role='button'>Campus Director</a>";

		if (lp_status == "sent") {
			buttons += "<a class='btn btn-success' role='button'>BAC</a>";
		} else {
			buttons += "<a class='btn btn-danger' role='button'>BAC</a>";
		}

		buttons += "<a class='btn btn-dark' role='button'>Procurement</a>";
		buttons += "<a class='btn btn-dark' role='button'>Supplies</a>";
		buttons += "<a class='btn btn-dark' role='button'>Section Head</a>";

	} else if (status == "Campus Director") {
		var buttons = "<a class='btn btn-success' role='button'>Department Head</a>";
		buttons += "<a class='btn btn-success' role='button'>ADAA</a>";

		if (lp_status == "sent") {
			buttons += "<a class='btn btn-success' role='button'>Campus Director</a>";
		} else {
			buttons += "<a class='btn btn-danger' role='button'>Campus Director</a>";
		}

		buttons += "<a class='btn btn-dark' role='button'>BAC</a>";
		buttons += "<a class='btn btn-dark' role='button'>Procurement</a>";
		buttons += "<a class='btn btn-dark' role='button'>Supplies</a>";
		buttons += "<a class='btn btn-dark' role='button'>Section Head</a>";

	} else if (status == "ADAA") {
		var buttons = "<a class='btn btn-success' role='button'>Department Head</a>";

		if (lp_status == "sent") {
			buttons += "<a class='btn btn-success' role='button'>ADAA</a>";
		} else {
			buttons += "<a class='btn btn-danger' role='button'>ADAA</a>";
		}

		buttons += "<a class='btn btn-dark' role='button'>Campus Director</a>";
		buttons += "<a class='btn btn-dark' role='button'>BAC</a>";
		buttons += "<a class='btn btn-dark' role='button'>Procurement</a>";
		buttons += "<a class='btn btn-dark' role='button'>Supplies</a>";
		buttons += "<a class='btn btn-dark' role='button'>Section Head</a>";

	} else if (status == "Department Head") {
		if (lp_status == "sent") {
			var buttons = "<a class='btn btn-success' role='button'>Department Head</a>";
		} else {
			var buttons = "<a class='btn btn-danger' role='button'>Department Head</a>";
		}

		buttons += "<a class='btn btn-dark' role='button'>ADAA</a>";
		buttons += "<a class='btn btn-dark' role='button'>Campus Director</a>";
		buttons += "<a class='btn btn-dark' role='button'>BAC</a>";
		buttons += "<a class='btn btn-dark' role='button'>Procurement</a>";
		buttons += "<a class='btn btn-dark' role='button'>Supplies</a>";
		buttons += "<a class='btn btn-dark' role='button'>Section Head</a>";
	}

	return buttons;
}

// start modal larger
	$('#li_items_tab').on("click", function() {
		$('#modal-larger-class').addClass('modal-larger');
	});

	$('#li_status_tab').on("click", function() {
		$('#modal-larger-class').removeClass('modal-larger');
	});

// logs_modal_btn
	$(document).on('click', '#logs_modal_btn[data-id]', function() {
		$.ajax({
			type: "POST",
			url: "{{route('requests.modal_view')}}",
			data: {
				submit: "logs_modal_btn",
				id: $(this).data('id'),
			},
			success: function(data){
				console.log(data.items.request_items_line);

				var items_data = JSON.parse(JSON.stringify(data.items.request_items_line).replace(/null/g, '" "'));
				table3.clear().draw();

				$.each(items_data, function( k, v ) {
					var table3_data = [];

					table3_data.push(v.created_at);
					table3_data.push(v.quantity + " " + data.items.item.unit);
					table3_data.push(v.cost);
					table3_data.push(v.total);

					table3.row.add(table3_data).draw().nodes().to$();

				});	

				$('#logs_modal').modal('show');

			},
			errors: function(data){
				alert(data);
			},
		});		
	});


var table2 = $('#Table2').DataTable();
var table3 = $('#logs_table').DataTable();
	
});
</script>