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

    <style type="text/css" media="print">
        @page { margin: 0; size: landscape; }
    </style>
</head>

<body>

    <div class="col-md-12">
        <br>
        <div class="panel-body" style="display: block;">
            <div class = "center">
                <h4><b>TECHNOLOGICAL UNIVERSITY OF THE PHILIPPINES - TAGUIG CAMPUS</b></h4>
                <p>Km 14 East Service Road Western Bicutan Taguig City</p>
                <!-- <br> -->
                <h4><b>PROJECT PROCUREMENT MANAGEMENT PLAN (PPMP)</b></h4>
                <h6>FY: {{$ppmp->fiscal_year}}</h6>
            </div>

            @if($ppmp->type == "Supplemental") <span style="float: left;padding-left: 5px;font-weight: bold;">SUPPLEMENTAL </span> <span style="padding-left: 50px;">@else <span>@endif End User/Unit: <b>{{$ppmp->course}}</b></span>

            <table class = "table table-bordered">
                <thead>
                  <tr>
                    <th class = "center" rowspan="2" style = "vertical-align: middle;">Code</th>
                    <th class = "center" rowspan="2" style = "vertical-align: middle;">General Description</th>
                    <th class = "center" rowspan="2" style = "vertical-align: middle;">Quantity /<br>Size</th>
                    <th class = "center" rowspan="2" style = "vertical-align: middle;">Unit</th>
                    <th class = "center" rowspan="2" style = "vertical-align: middle;">Cost</th>
                    <th class = "center" rowspan="2" style = "vertical-align: middle;">Total Cost</th>
                    <th class = "center" colspan="12">Schedule/ Milestone of Activities</th>
                </tr>
                <tr>
                    <td class = "center">Jan</td>
                    <td class = "center">Feb</td>
                    <td class = "center">Mar</td>
                    <td class = "center">Apr</td>
                    <td class = "center">May</td>
                    <td class = "center">June</td>
                    <td class = "center">July</td>
                    <td class = "center">Aug</td>
                    <td class = "center">Sept</td>
                    <td class = "center">Oct</td>
                    <td class = "center">Nov</td>
                    <td class = "center">Dec</td>
                </tr>
            </thead>
            <tbody>
                <!-- insert approved items here from ppmp -->
                @if(!$Supplies->item->isEmpty())
                <tr>
                    <td></td>
                    <td class = "center"><b>Supplies</b></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>

                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                @endif
                <!-- foreach here -->
                @foreach($ppmp->item as $items)
                @if($items->category == "Supplies")
                <tr>
                    <td class="center">{{$items->code}}</td>
                    <td class="center">{{$items->description}}</td>
                    <td class="center">{{$items->quantity}}</td>
                    <td class="center">{{$items->unit}}</td>
                    <td align="right">{{$items->cost}}</td>
                    <td align="right">{{number_format($items->total,2)}}</td>
                    <!-- schedule -->
                    <td class = "center">@if(in_array("Jan",explode(",", $items->schedule))) x @endif</td>
                    <td class = "center">@if(in_array("Feb",explode(",", $items->schedule))) x @endif</td>
                    <td class = "center">@if(in_array("Mar",explode(",", $items->schedule))) x @endif</td>
                    <td class = "center">@if(in_array("Apr",explode(",", $items->schedule))) x @endif</td>
                    <td class = "center">@if(in_array("May",explode(",", $items->schedule))) x @endif</td>
                    <td class = "center">@if(in_array("June",explode(",", $items->schedule))) x @endif</td>
                    <td class = "center">@if(in_array("July",explode(",", $items->schedule))) x @endif</td>
                    <td class = "center">@if(in_array("Aug",explode(",", $items->schedule))) x @endif</td>
                    <td class = "center">@if(in_array("Sept",explode(",", $items->schedule))) x @endif</td>
                    <td class = "center">@if(in_array("Oct",explode(",", $items->schedule))) x @endif</td>
                    <td class = "center">@if(in_array("Nov",explode(",", $items->schedule))) x @endif</td>
                    <td class = "center">@if(in_array("Dec",explode(",", $items->schedule))) x @endif</td>
                    <!-- end schedule -->
                </tr>
                @endif
                @endforeach
                <!-- end foreach supplies -->
                @if(!$Equipment->item->isEmpty())
                <tr>
                    <td></td>
                    <td class = "center"><b>Equipment</b></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>

                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                @endif
                <!-- start equipment foreach -->
                @foreach($ppmp->item as $items)
                @if($items->category == "Equipment")
                <tr>
                    <td class="center">{{$items->code}}</td>
                    <td class="center">{{$items->description}}</td>
                    <td class="center">{{$items->quantity}}</td>
                    <td class="center">{{$items->unit}}</td>
                    <td align="right">{{$items->cost}}</td>
                    <td align="right">{{number_format($items->total,2)}}</td>
                    <!-- schedule -->
                    <td class = "center">@if(in_array("Jan",explode(",", $items->schedule))) x @endif</td>
                    <td class = "center">@if(in_array("Feb",explode(",", $items->schedule))) x @endif</td>
                    <td class = "center">@if(in_array("Mar",explode(",", $items->schedule))) x @endif</td>
                    <td class = "center">@if(in_array("Apr",explode(",", $items->schedule))) x @endif</td>
                    <td class = "center">@if(in_array("May",explode(",", $items->schedule))) x @endif</td>
                    <td class = "center">@if(in_array("June",explode(",", $items->schedule))) x @endif</td>
                    <td class = "center">@if(in_array("July",explode(",", $items->schedule))) x @endif</td>
                    <td class = "center">@if(in_array("Aug",explode(",", $items->schedule))) x @endif</td>
                    <td class = "center">@if(in_array("Sept",explode(",", $items->schedule))) x @endif</td>
                    <td class = "center">@if(in_array("Oct",explode(",", $items->schedule))) x @endif</td>
                    <td class = "center">@if(in_array("Nov",explode(",", $items->schedule))) x @endif</td>
                    <td class = "center">@if(in_array("Dec",explode(",", $items->schedule))) x @endif</td>
                    <!-- end schedule -->
                </tr>
                @endif
                @endforeach
                <!-- end equipment foreach -->
                <tr style = "border:2px solid ;">
                    <td></td>
                    <td class = "center"><b>Total</b></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td><b><span style = "text-align:left;">Php</span><span style = "float:right;">{{number_format($total,2)}}</span></b></td>

                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>

                <!-- end insert -->
            </tbody>
        </table>

        <p>Note: Technical Specifications for each Item / Project being proposed shall be submitted as part of the PPMP.</p>
        <div class = "row">
            <div class="col-md-3 col-xs-3">
                <p>Prepared by:</p>
                @if($ppmp->prepared['signature'])
                <center><img src="{{$ppmp->prepared['signature']}}" height="19"></center>
                @else
                <br>
                @endif
                <p class="center"><b><u>{{$ppmp->prepared['name']}}</u></b></p>
                <p class="center">{{$ppmp->prepared['role']}}</p>
            </div>
            <div class="col-md-3 col-xs-3">
                <p>Recommended by:</p>
                @if($ADAA['signature'])
                <center><img src="{{$ADAA['signature']}}" height="19"></center>
                @else
                <br>
                @endif
                <p class="center text-uppercase"><b><u>{{$ADAA['name']}}</u></b></p>
                <p class="center">{{$ADAA['role']}}</p>
            </div>
            <div class="col-md-3 col-xs-3">
                <p>Evaluated by:</p>
                @if($Budget['signature'])
                <center><img src="{{$Budget['signature']}}" height="19"></center>
                @else
                <br>
                @endif
                <p class="center text-uppercase"><b><u>{{$Budget['name']}}</u></b></p>
                <p class="center">AO V-Budget</p>
            </div>
            <div class="col-md-3 col-xs-3">
                <p>Approved by:</p>
                @if($Director['signature'])
                <center><img src="{{$Director['signature']}}" height="19"></center>
                @else
                <br>
                @endif
                <p class="center text-uppercase"><b><u>{{$Director['name']}}</u></b></p>
                <p class="center">{{$Director['role']}}</p>
            </div>
        </div>
    </div>
</div>

<!-- Vendor -->
<script src="{{asset('assets/vendor/jquery/jquery.js')}}"></script>
<script src="{{asset('assets/vendor/jquery-browser-mobile/jquery.browser.mobile.js')}}"></script>
<script src="{{asset('assets/vendor/bootstrap/js/bootstrap.js')}}"></script>
<script src="{{asset('assets/vendor/nanoscroller/nanoscroller.js')}}"></script> 
<script src="{{asset('assets/vendor/jquery-placeholder/jquery.placeholder.js')}}"></script>

<script>
    $(document).ready(function() {
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

