<!doctype html>
<html class="fixed sidebar-left-collapsed">
<head>

    <!-- Basic -->
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="keywords" content="TUPT Traceability of Request" />
    <meta name="description" content="Traceability of Request for Equipment\Supplies\Materials">
    <meta name="author" content="Mendoza Calulo">

    <!-- Mobile Metas -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    
    <link rel="icon" href="{{asset('assets/images/!happy-face.png')}}" type="image">

    <!-- Web Fonts  -->
    <link href="http://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800|Shadows+Into+Light" rel="stylesheet" type="text/css">

    <!-- Vendor CSS -->
    <link rel="stylesheet" href="{{asset('assets/vendor/bootstrap/css/bootstrap.css')}}" /> 
    <link rel="stylesheet" href="{{asset('assets/vendor/font-awesome/css/font-awesome.min.css')}}" /> 

    <!-- Theme CSS -->
    <link rel="stylesheet" href="{{asset('assets/stylesheets/theme.css')}}" />

    <!-- Skin CSS -->
    <link rel="stylesheet" href="{{asset('assets/stylesheets/skins/default.css')}}" />

    <!-- Theme Custom CSS -->
    <link rel="stylesheet" href="{{asset('assets/stylesheets/theme-custom.css')}}">

    <!-- Head Libs -->
    <script src="{{asset('assets/vendor/modernizr/modernizr.js')}}"></script>

    <style type="text/css" media="print"></style>
</head>

<body>

<section role="main" class="content-body" id="printview">
    <div class="row">
        <div class="panel-body">
            <img src="{{asset('assets/images/request_sample_header2.png')}}" style="width: 100%;">
            <div class="col-md-1 col-xs-1 col-lg-1"></div>
            <div class="col-md-11 col-xs-11 col-lg-11">
                <div class="row">
                    <div class="col-md-12">
                        <span style="float: right; padding-right: 20px;">{{$req->date}}</span>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <table style="width:100%;">
                            <tbody>
                                <tr>
                                    <td>
                                        @if(!empty($req->campus_director['signature']))
                                        <img src="{{$req->campus_director['signature']}}" height="19" style="padding-left: 15px;">&nbsp;&nbsp;<span style = "font-size: xx-small;">{{$req->campus_director['date']}}</span>
                                        @endif
                                        <br>
                                        <b>{{$req->campus_director['name']}}</b><br>
                                        {{$req->campus_director['role']}}
                                    </td>
                                    <td>
                                        @if(!empty($req->department_head['comment']))
                                            {{$req->department_head['comment']}}
                                        @elseif(!empty($req->adaa['comment']))
                                            {{$req->adaa['comment']}}
                                        @elseif(!empty($req->campus_director['comment']))
                                            {{$req->campus_director['comment']}}
                                        @endif
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <br>
                    
                <div class="center">
                    @if(!empty($req->adaa['signature']))
                    <img src="{{$req->adaa['signature']}}" height="19" style="padding-left: 15px;">&nbsp;&nbsp;<span style = "font-size: xx-small;">{{$req->adaa['date']}}</span><br>
                    @endif  
                    Thru: <b>{{$req->adaa['name']}}</b><br>
                    <span style="padding-left: 85px;">{{$req->adaa['role']}}</span>
                </div>
                <br>

                <!-- content -->
                {!! $req->content !!}
                <div class="row">
                    <div class="col-md-6">
                        @if(!empty($req->section_head['signature']))
                        <img src="{{$req->section_head['signature']}}" height="19"><br>
                        @endif
                        {{$req->section_head['name']}}<br>
                        {{$req->section_head['role']}}<br>
                        <br>
                        @if(!empty($req->department_head['signature']))
                        <img src="{{$req->department_head['signature']}}" height="19" style="padding-left: 15px;">&nbsp;&nbsp;<span style = "font-size: xx-small;">{{$req->department_head['date']}}</span>
                        @endif
                        <br>
                        {{$req->department_head['name']}}<br>
                        {{$req->department_head['role']}}
                    </div>
                </div>
                <br>
            </div>
        </div>
    </div>
</section>
<!-- Vendor -->
<script src="{{asset('assets/vendor/jquery/jquery.js')}}"></script>
<script src="{{asset('assets/vendor/jquery-browser-mobile/jquery.browser.mobile.js')}}"></script>
<script src="{{asset('assets/vendor/bootstrap/js/bootstrap.js')}}"></script>
<script src="{{asset('assets/vendor/nanoscroller/nanoscroller.js')}}"></script> 
<script src="{{asset('assets/vendor/jquery-placeholder/jquery.placeholder.js')}}"></script>

<script>
    $(document).ready(function() {
        var printcontent = document.getElementById('printview').innerHTML;
        document.body.innerHTML = printcontent;
        window.print();
    });
</script>

<!-- Theme Base, Components and Settings -->
<script src="{{asset('assets/javascripts/theme.js')}}"></script>

<!-- Theme Custom -->
<script src="{{asset('assets/javascripts/theme.custom.js')}}"></script>

<!-- Theme Initialization Files -->
<script src="{{asset('assets/javascripts/theme.init.js')}}"></script>


</body>
</html>

