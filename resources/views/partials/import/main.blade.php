<!-- datatable -->
@if($import == "datatable")
	@if($type == "css")
		<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs/dt-1.10.18/b-1.5.6/b-colvis-1.5.6/b-flash-1.5.6/b-print-1.5.6/r-2.2.2/datatables.min.css"/>
	@elseif($type == "js")
		<script type="text/javascript" src="https://cdn.datatables.net/v/bs/dt-1.10.18/b-1.5.6/b-colvis-1.5.6/b-flash-1.5.6/b-print-1.5.6/r-2.2.2/datatables.min.js"></script>
	@endif
<!-- cleave js -->
@elseif($import == "cleave_js")
	<script src="{{asset('assets/javascripts/cleave.min.js')}}"></script>

<!-- bootstrap file upload -->
@elseif($import == "bs_file_upload")
	@if($type == "css")
		<link rel="stylesheet" href="{{asset('assets/vendor/bootstrap-fileupload/bootstrap-fileupload.min.css')}}" />
	@elseif($type == "js")
		<script src="{{asset('assets/vendor/bootstrap-fileupload/bootstrap-fileupload.min.js')}}"></script>
	@endif

@elseif($import == "bs_multiselect")
	@if($type == "css")
		<link rel="stylesheet" href="{{asset('assets/vendor/bootstrap-multiselect/bootstrap-multiselect.css')}}" />
	@elseif($type == "js")
		<script src = "{{asset('assets/vendor/bootstrap-multiselect/bootstrap-multiselect.js')}}"></script>
	@endif

@elseif($import == "datepicker")
	@if($type == "css")
		<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
		<style>
			.ui-datepicker select.ui-datepicker-month, .ui-datepicker select.ui-datepicker-year {
				width: 50%;
			}
		</style>
	@elseif($type == "js")
		<script src = "{{asset('assets/datepicker/jquery-ui.js')}}"></script>
	@endif

@elseif($import == "ckeditor")
	@if($type == "js")
		<script src="{{asset('assets/ckeditor/ckeditor.js')}}"></script>
	@elseif($type == "css")
		<style>
		  :root {
		    --ck-sample-base-spacing: 2em;
		    --ck-sample-color-white: #fff;
		    --ck-sample-color-green: #279863;
		  }
		  .centered {
		    max-width: 960px;
		    margin: 0 auto;
		    padding: 0 var(--ck-sample-base-spacing);
		  }
		  #editor {
		    background: var(--ck-sample-color-white);
		    box-shadow: 2px 2px 2px rgba(0,0,0,.1);
		    border: 1px solid #DFE4E6;      
		    border-bottom-color: #cdd0d2;
		    border-right-color: #cdd0d2;
		  }
		  .ck.ck-editor {
		    box-shadow: 2px 2px 2px rgba(0,0,0,.1);
		  }
		  .ck.ck-content {
		    font-size: 1em;
		    line-height: 1.6em;
		    /*margin-bottom: 0.8em;*/
		    min-height: 200px;
		    padding: 1.5em 2em;
		  }
		  .document-editor {
		    border: 1px solid #DFE4E6;
		    border-bottom-color: #cdd0d2;
		    border-right-color: #cdd0d2;
		    border-radius: 2px;
		    max-height: 700px;
		    display: flex;
		    flex-flow: column nowrap;
		    box-shadow: 2px 2px 2px rgba(0,0,0,.1);
		  }
		  .toolbar-container {
		    z-index: 1;
		    position: relative;
		    box-shadow: 2px 2px 1px rgba(0,0,0,.05);
		   }
		   .toolbar-container .ck.ck-toolbar {
		    border-top-width: 0;
		    border-left-width: 0;
		    border-right-width: 0;
		    border-radius: 0;
		   }
		  .content-container {
		    /*padding: var(--ck-sample-base-spacing);
		    background: #eee;*/
		    /*overflow-y: scroll;*/
		  }
		  .content-container #editor {
		    border-top-left-radius: 0;
		    border-top-right-radius: 0;

		    /*width: 210mm;*/
		    min-height: 130mm;
		    /*padding: 1cm 1cm 2cm;*/
		    /*margin: 0 auto;*/
		    box-shadow: 2px 2px 1px rgba(0,0,0,.05);
		  }
		</style>
	@endif

@endif

