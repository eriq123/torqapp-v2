@extends('layouts.index')
@section('content')
<section role="main" class="content-body">
	@include('partials.role-header')
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
	<form action="{{route('sample.data')}}" method="post"> 
	@csrf
	<button 
		style="display: none;"
		type="submit" 
		class="btn btn-success">
			Create sample data
		</button>
	</form>

	<!-- reports -->

	<!-- still thinking if the table is necessary -->

	<div class="row">
		<div class="col-xs-12" id = "SSEBudgetCanvasHide">
			<div id="SSEBudgetCanvas" style="height: 50vh; width: 100%;"></div>
		</div>
	</div>
	
	<hr>

	<div class="row">
		<div class="col-xs-12" id = "SpentVsRemainingCanvasHide">
			<div id="SpentVsRemainingCanvas" style="height: 50vh; width: 100%;"></div>
		</div>
	</div>

</section>
@endsection
@section('js')
<script>
$(document).ready(function(){
	$.ajax({
		type: 'post',
		url: "{{route('section.reports')}}",
		success: function(data){
			console.log(data);

			// SpentVsRemainingCanvas
			    var options = {
			      animationEnabled: true,
			      title:{
			        text: "Remaining Budget VS Spent Budget"
			      },
			      axisY:{
			        title:"Php"
			      },
			      toolTip: {
			        shared: true,
			        reversed: true
			      },
			      data: [
			      {
			        type: "stackedColumn",
			        name: "Spent Budget",
			        showInLegend: "true",
			        yValueFormatString: "Php #,##0.00",
			        dataPoints: [
			        { y: data.total.supplies , label: "Supplies Budget" },
			        { y: data.total.equipment, label: "Equipment Budget" },
			        { y: data.total.supplemental, label: "Supplemental Budget" },
			        ]
			      },
			      {
			        type: "stackedColumn",
			        name: "Remaining Budget",
			        showInLegend: "true",
			        yValueFormatString: "Php #,##0.00",
			        dataPoints: [
			        { y: parseInt(data.course.supplies) , label: "Supplies Budget" },
			        { y: parseInt(data.course.equipment), label: "Equipment Budget" },
			        { y: parseInt(data.course.supplemental), label: "Supplemental Budget" },
			        ]
			      }

			      
			      ]
			    };
			    $("#SpentVsRemainingCanvas").CanvasJSChart(options);

			// SSEBudgetCanvas
			    var chart4 = new CanvasJS.Chart("SSEBudgetCanvas",{
			    	title: {
			    		text: "Remaining Budget Vs. Spent Budget "
			    	},
			    	animationEnabled: true,
			    	data: [{
			    		type: "doughnut",
			    		innerRadius: "40%",
			    		showInLegend: true,
			    		legendText: "{label} P {y}.00 ",
			    		indexLabel: "{label}: #percent%",
			    		dataPoints: [
			    		{ label: "Remaining Budget", y: (parseInt(data.course.supplies) + parseInt(data.course.equipment) + parseInt(data.course.supplemental)) - (parseInt(data.total.supplies + data.total.equipment + data.total.supplemental))  },
			    		{ label: "Spent Budget", y: parseInt(data.total.supplies + data.total.equipment + data.total.supplemental) },
			    		]
			    	}]
			    });
			    chart4.render();

		},
	});
});
</script>
@endsection
@section('css')

@endsection

