@extends('layouts.index')
@section('content')
<section role="main" class="content-body">
  @include('partials.role-header')
  <div class = "row">
    <div class="col-md-12">
      <div class="panel-body"  style="display: block;">
        <table border="1" class = "table">
          <tbody>
            <tr>
              <td class="col-md-8 col-xs-8" style="padding: 10px;">
                <div class = "row">
                  <div class = "col-md-6 col-md-offset-3 col-xs-12 inline" >
                    <img src="{{asset('assets/images/tup.png')}}" alt="" border=3 height=50 width=50 style="float:left;">
                    <img src="{{asset('assets/images/tuv.png')}}" alt="" border=3 height=40 width=50 style="float:right;">
                    <p class = "center"><b>TECHNOLOGICAL UNIVERSITY OF THE PHILIPPINES 
                      <br> TAGUIG CITY</b>
                    </p>
                  </div>
                </div>
                <div class="row">
                  <div class="col-xs-12 center">
                    The Technological University of the Philippines shall be a premier state university with recognized excellence in engineering and technology education at par with leading universities in the ASEAN region.
                  </div>
                </div>
              </td>
              <td class="col-md-4 col-xs-4" style="padding: 25px;">
                <center><h4><b>ANNUAL PROCUREMENT PLAN</b></h4></center>
                <center><span style = "margin-right: 20px;">FM-TUPT-APP</span><span style = "margin-right: 20px;">REV 1</span><span>09DEC2016</span></center>
              </td>
            </tr>
          </tbody>
        </table>
        <h5 class="center"><b>@if($app->type == "Supplemental") <span style="float: left;padding-left: 50px;">SUPPLEMENTAL</span> @endif Annual Procurement Plan for FY {{$app->fiscal_year}}</b></h5>
        <table border="1" class="col-md-12" class = "table">
          <thead>
            <tr>
              <th class = "center" rowspan="2">Code<br>(PAP)</th>
              <th class = "center" rowspan="2">Procurement Program/ Project</th>
              <th class = "center" rowspan="2">PMO/<br>End-User</th>
              <th class = "center" rowspan="2">Mode of<br>Procurement</th>
              <th class = "center" colspan="4">Schedule for Each Procurement Activity</th>
              <th class = "center" rowspan="2">Source of<br>Funds</th>
              <th class = "center" colspan="3">Estimated Budget (PhP)</th>
              <th class = "center" rowspan="2">Remarks<br>(brief description of<br> Program/Project)</th>
            </tr>
            <tr>
              <td class = "center">Ads/Post of IB/REI</td>
              <td class = "center">Sub/Open of Bids</td>
              <td class = "center">Notice of Award</td>
              <td class = "center">Contract Signing</td>
              <td class = "center">Total</td>
              <td class = "center">MOOE</td>
              <td class = "center">CO</td>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td></td>
              <td colspan="3" align="center">{{$app->course}}</td>
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
            @foreach($app->item as $items)
            <tr>
              <td>&nbsp;{{$items->code}}</td>
              <td>&nbsp;{{$items->quantity}} - {{$items->description}}</td>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
              <td align="right">{{number_format($items->total,2)}}&nbsp;</td>
              <td></td>
              <td></td>
              <td></td>
            </tr>
            @endforeach
            <tr style = "height: 23px;">
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
            <tr>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
              <td align="center"><b>TOTAL</b></td>
              <td align="right"><b>{{number_format($total,2)}}</b>&nbsp;</td>
              <td></td>
              <td></td>
              <td></td>
            </tr>
          </tbody>
        </table>
        @if($app->prepared)
        <div class = "row">
          <div class="col-md-4 col-xs-4">
            <p>Prepared by:</p>
            @if($app->prepared['signature'])
            <img src="{{ $app->prepared['signature'] }}" alt="Signature" height = "19"  />
            @endif
            <br>
            <b>{{$app->prepared['name']}}</b>
            <p>BAC Secretary</p>
          </div>
          @if($app->recommended)
          <div class="col-md-4 col-xs-4">
            <p>Recommending Approval:</p>
            @if($app->recommended['signature'])
            <img src="{{ $app->recommended['signature'] }}" alt="Signature" height = "19" />
            @endif
            <br>
            <b>{{$app->recommended['name']}}</b>
            <p>BAC Chairman</p>
          </div>
          @endif
          @if($app->approved)
          <div class="col-md-4 col-xs-4">
            <p>Approved by:</p>
            @if($app->approved['signature'])
            <img src="{{ $app->approved['signature'] }}" alt="Signature" height = "19" />
            @endif
            <br>
            <b>{{$app->approved['name']}}</b>
            <p>Campus Director</p>
          </div>
          @endif
        </div>
        @endif
      </div>
    </div>
  </div>
</section>



@stop
