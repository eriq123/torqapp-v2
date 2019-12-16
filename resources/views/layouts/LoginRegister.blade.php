<!DOCTYPE html>
<html class="fixed">
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
    <link rel="stylesheet" href="{{asset('assets/vendor/font-awesome/css/font-awesome.css')}}" /> 
    
    <!-- Theme CSS -->
    <link rel="stylesheet" href="{{asset('assets/stylesheets/theme.css')}}" />

    <!-- Skin CSS -->
    <link rel="stylesheet" href="{{asset('assets/stylesheets/skins/default.css')}}" />

    <!-- Theme Custom CSS -->
    <link rel="stylesheet" href="{{asset('assets/stylesheets/theme-custom.css')}}">

    <!-- Head Libs -->
    <script src="{{asset('assets/vendor/modernizr/modernizr.js')}}"></script>

</head>
<body>


    <!-- start: page -->
    @yield('LoginRegisterContent')
    <!-- end: page -->

    <!-- Vendor -->
    <script src="{{asset('assets/vendor/jquery/jquery.js')}}"></script>
    <script src="{{asset('assets/vendor/jquery-browser-mobile/jquery.browser.mobile.js')}}"></script>
    <script src="{{asset('assets/vendor/bootstrap/js/bootstrap.js')}}"></script>
    <script src="{{asset('assets/vendor/nanoscroller/nanoscroller.js')}}"></script>
    <script src="{{asset('assets/vendor/jquery-placeholder/jquery.placeholder.js')}}"></script>
    
    <!-- Theme Base, Components and Settings -->
    <script src="{{asset('assets/javascripts/theme.js')}}"></script>
    
    <!-- Theme Custom -->
    <script src="{{asset('assets/javascripts/theme.custom.js')}}"></script>
    
    <!-- Theme Initialization Files -->
    <script src="{{asset('assets/javascripts/theme.init.js')}}"></script>
    
    <script type="text/javascript">
        $(document).ready(function(){
            $('.alert').delay(2000).fadeOut('slow');
            
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
        });
    </script>

    @yield('js')

</body>
</html>

