@extends('layouts.index')
@section('content')

<section role="main" class="content-body">
	@include('partials.role-header')

	<div class="row" style = "margin-top: 25px;">
		<div class="col-md-4 col-lg-3">
			<section class="panel">
				<div class="panel-body">
					<div class="thumb-info mb-md">
						<img src="{{asset('assets/images/group.png')}}" class="rounded img-responsive" alt="user image">
						<div class="thumb-info-title">
							<span class="thumb-info-inner">{{ Auth::user()->full_name }}</span>
							<span class="thumb-info-type">{{Auth::user()->RoleName}}</span>
						</div>
					</div>

					<hr class="dotted short">

				</div>
			</section>
		</div>

		<div class="col-md-8 col-lg-9">
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
			<div class="tabs">
				<ul class="nav nav-tabs tabs-primary">
				<li class = "active">
					<a href="#esig" data-toggle="tab">eSignature</a>
				</li>
				<li>
					<a href="#edit" data-toggle="tab">Information</a>
				</li>
				<li >
					<a href="#account" data-toggle="tab">Account</a>
				</li>
			</ul>
			<!-- tab contents here -->
			<div class="tab-content">


				<!-- first tab start -->
				<div id="esig" class="tab-pane active">
					<form class="form-horizontal">
						@if(Auth::user()->signature)
						<h4 class="mb-xlg">Digital Signature</h4>
						<div class="row">
							<div class = "col-md-offset-3 col-md-6">
								<img src="{{ Auth::user()->signature }}" alt="Signature" height="75" />
							</div>
						</div>
						@endif

						<hr>
						
						<h4 class="mb-xlg">Add\Replace Signature</h4>
						<fieldset class="mb-xl">
							<!-- signature starts here -->
							<div id = "outsidediv">
								<div id="content">
									<div id="signatureparent">
										<div id="signature"></div>
									</div>
								</div>
								<div id="scrollgrabber"></div>
							</div>
							<!-- ends here esig -->
						</fieldset>
						<div class="panel-footer">
							<div class="row">
								<div class="col-md-9 col-md-offset-4">
									<button type="button" class="btn btn-primary" id = "signaturebtn">Submit</button>
									<button type="button" class="btn btn-warning" id = "reset">Reset</button>
									<button onclick="window.location='{{ route('main.profile') }}'" type="button" class="btn btn-default" >Cancel</button>
									
								</div>
							</div>
						</div>
					</form>
				</div>
				<!-- first tab end -->

				<!-- second tab -->
				<div id="edit" class="tab-pane">
					<form class="form-horizontal" method = "POST" action = "{{route('main.submit_profile')}}" enctype="multipart/form-data">
						@csrf
						<h4 class="mb-xlg">Edit Personal Information</h4><hr>
						<fieldset>
							<div class="form-group">
								<label class="col-md-3 control-label" for="profiletitle">Title</label>
								<div class="col-md-8">
									<input type="text" class="form-control" name = "Title" id="Title" value = "{{Auth::user()->title}}" placeholder="e.g. Mr. Ms. Engr. Dr.">
								</div>
							</div>
							<div class="form-group">
								<label class="col-md-3 control-label" for="profileFirstName">First Name</label>
								<div class="col-md-8">
									<input type="text" class="form-control" name = "profileFirstName" id="profileFirstName" value = "{{Auth::user()->first_name}}" required>
								</div>
							</div>
							<div class="form-group">
								<label class="col-md-3 control-label" for="profileLastName">Last Name</label>
								<div class="col-md-8">
									<input type="text" class="form-control" name = "profileLastName" id="profileLastName" value = "{{Auth::user()->last_name}}" required>
								</div>
							</div>
							<div class="form-group">
								<label class="col-md-3 control-label">Upload Image</label>
								<div class="col-md-6">
									<div class="fileupload fileupload-new" data-provides="fileupload">
										<div class="input-append">
											<div class="uneditable-input">
												<i class="fa fa-file fileupload-exists"></i>
												<span class="fileupload-preview"></span>
											</div>
											<span class="btn btn-default btn-file">
												<span class="fileupload-exists">Change</span>
												<span class="fileupload-new">Select file</span>
												<input type="file" id="image" name="image">
											</span>
											<a href="#" class="btn btn-default fileupload-exists" data-dismiss="fileupload">Remove</a>
										</div>
									</div>
								</div>
							</div>
						</fieldset>
						<div class="panel-footer">
							<div class="row">
								<div class="col-md-8 col-md-offset-4">
									<button type="submit" class="btn btn-primary">Submit</button>
									<button onclick="window.location='{{ route('main.profile') }}'" type="button" class="btn btn-default" >Cancel</button>
								</div>
							</div>
						</div>
					</form>
				</div>
				<!-- end second tab -->

				<!-- third tab -->
				<div id="account" class="tab-pane">
					<form class="form-horizontal" method="POST" action="{{route('main.password')}}">
						@csrf
						<h4 class="mb-xlg">Edit Account Details</h4><hr>
						<!-- <h4 class="mb-xlg">Change Username and Password<br><small><span style="color:#FF0000;">*</span>Please try to have atleast 6 characters.</small></h4> -->
						<fieldset class="mb-xl">
							<div class="form-group">
								<label class="col-md-3 control-label" for="profileLastName">Username</label>
								<div class="col-md-8">
									<input type="text" class="form-control" name = "username" id="username" value = "{{Auth::user()->username}}" required>
								</div>
							</div>
							<div class="form-group">
								<label class="col-md-3 control-label" for="current_password">Current Password</label>
								<div class="col-md-8">
									<input name="current_password" type="password" class="form-control" id="current_password" required>
								</div>
							</div>
							<div class="form-group">
								<label class="col-md-3 control-label" for="new-password">New Password</label>
								<div class="col-md-8">
									<input name="new-password" type="password" class="form-control" id="new-password" required>
								</div>
							</div>
							<div class="form-group">
								<label class="col-md-3 control-label" for="new-password_confirmation">Confirm Password</label>
								<div class="col-md-8">
									<input id="new-password_confirmation" type="password" class="form-control"  name="new-password_confirmation" required>
								</div>
							</div>
						</fieldset>
						<div class="panel-footer">
							<div class="row">
								<div class="col-md-9 col-md-offset-4">
									<button type="submit" class="btn btn-primary">Submit</button>
									<button onclick="window.location='{{ route('main.profile') }}'" type="button" class="btn btn-default" >Cancel</button>
								</div>
							</div>
						</div>
					</form>
				</div>
				<!-- end third tab -->
			</div>
		</div>
	</div>
</section>
@endsection
@section('js')

@include('partials.import.main',['import'=>"bs_file_upload",'type'=>"js"])

<script type="text/javascript">
// jQuery.noConflict()
</script>
<script>
/*  @preserve
jQuery pub/sub plugin by Peter Higgins (dante@dojotoolkit.org)
Loosely based on Dojo publish/subscribe API, limited in scope. Rewritten blindly.
Original is (c) Dojo Foundation 2004-2010. Released under either AFL or new BSD, see:
http://dojofoundation.org/license for more information.
*/
(function($) {
	var topics = {};
	$.publish = function(topic, args) {
		if (topics[topic]) {
			var currentTopic = topics[topic],
			args = args || {};

			for (var i = 0, j = currentTopic.length; i < j; i++) {
				currentTopic[i].call($, args);
			}
		}
	};
	$.subscribe = function(topic, callback) {
		if (!topics[topic]) {
			topics[topic] = [];
		}
		topics[topic].push(callback);
		return {
			"topic": topic,
			"callback": callback
		};
	};
	$.unsubscribe = function(handle) {
		var topic = handle.topic;
		if (topics[topic]) {
			var currentTopic = topics[topic];

			for (var i = 0, j = currentTopic.length; i < j; i++) {
				if (currentTopic[i] === handle.callback) {
					currentTopic.splice(i, 1);
				}
			}
		}
	};
})(jQuery);

</script>
<script src="{{asset('assets/eSignature/libs/jSignature.min.noconflict.js')}}"></script>
<script>
	$('.alert').delay(2000).fadeOut('slow');

	(function($){

		$(document).ready(function() {

	// undo button
	var $sigdiv = $("#signature").jSignature({})
	// reset button
	$('#reset').bind('click', function(e){
		$sigdiv.jSignature('reset')
	})

	// signature button
	$(document).on('click','#signaturebtn',function(){
		var datapair = $('#signature').jSignature('getData','svgbase64');
		var sigdata = "data:" + datapair[0] + "," + datapair[1];
		console.log(sigdata);
		$.ajax({
			type: "POST",
			url: "{{route('main.signature')}}",
			data:{
				jsig: sigdata,
			},
			success: function(){
				var success = "<div class='alert alert-success'>";
				success += "Signature saved!";
				success += "</div>";
				$('.tabs').prepend(success);

				setTimeout(function(){
					window.location.reload();
				}, 850);
			},
		});
	})
	// end signature button

	// scroll grabber obviously
	if (Modernizr.touch){
		$('#scrollgrabber').height($('#content').height())		
	}
})

	})(jQuery)
</script>


@endsection
@section('css')

@include('partials.import.main',['import'=>"bs_file_upload",'type'=>"css"])

<style type="text/css">
	div#divoutside {
		margin-top:1em;
		margin-bottom:1em;
	}
	/*input {
		padding: .5em;
		margin: .5em;
		}*/
	/*select {
		padding: .5em;
		margin: .5em;
	}
	*/
	#signatureparent {
		color:black;
		background-color:white;
		/*max-width:600px;*/
		padding:20px;
	}
	
	/*This is the div within which the signature canvas is fitted*/
	#signature {
		border: 2px dotted lightgray;
		background-color:white;
	}

	/* Drawing the 'gripper' for touch-enabled devices */ 
	html.touch #content {
		float:left;
		width:92%;
	}
	html.touch #scrollgrabber {
		float:right;
		width:4%;
		margin-right:2%;
		background-image:url(data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAEAAAAFCAAAAACh79lDAAAAAXNSR0IArs4c6QAAABJJREFUCB1jmMmQxjCT4T/DfwAPLgOXlrt3IwAAAABJRU5ErkJggg==)
	}
	html.borderradius #scrollgrabber {
		border-radius: 1em;
	}
</style>

@endsection
