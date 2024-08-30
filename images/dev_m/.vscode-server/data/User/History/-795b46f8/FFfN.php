@extends('layouts.simple.master')
@section('title', 'Lead - Editar')

@section('css')
<link rel="stylesheet" type="text/css" href="{{asset('assets/css/vendors/date-picker.css')}}">
@endsection

@section('style')
@endsection

@section('breadcrumb-title')
<h3>Campanha <span style="color:rgba(0,0,0,.5)">{{ $campaign->name }}</span></h3>
@endsection

@section('content')
@if ($errors->any())

@endif


<div class="container-fluid">
    <div class="row">
        <div class="card">
            <div class="card-header p-3">
                <h5>Resumo</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-4">
                        <!-- <b>Total de leads:</b> {{count($campaign->leads)}}<br /><br /> -->

                        <h6>Leads por origem:</h6>
                        @foreach($campaign->leadsByOrigin as $id => $origin)
                        <b>{{$id}}- {{(campaignOrigins($campaign))[$origin['origin']]['name']}}:</b>
                        {{$origin['count']}}<br />
                        @endforeach

                    </div>
                    <div class="col-8">

                        <div id="chartdiv" style="width:100%; height:200px"></div>
                    </div>
                </div>
            </div>
        </div>


        <div class="col-sm-10 col-lg-8 col-md-8">
            <div class="card">
                <div class="card-body">
                    <div class="table-mobile-version table-responsive product-table">
                        <table class="table table-responsive table-hover">
                            <tr>
                                <th style="text-align:left;">Links</th>
                                <th>Origem</th>                                
                                <th>Total de Leads</th>
                            </tr>
                            @foreach(campaignOrigins($campaign) as $link)
                            <tr>
                                <td>{{$link['name']}}</td>                               
                                <td>
                                    <button class="btn" onclick='copyText("{{$link['name']}}", "{{$link['url']}}")'><span class="badge badge-primary" id="{{$link['name']}}">Copiar Link</span></button>
                                </td>
                                <td>
                                    {{count($campaign->leads)}}
                                </td>
                            </tr>
                            @endforeach
                        </table>
                    </div>
                </div>
            </div>
        </div>


        <div class="card">
            <div class="card-header p-3">

            </div>
            <div class="card-body">
                <div class="col-12">
                    @foreach(campaignOrigins($campaign) as $link)

                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>

<input type="hidden" id='leadsByOrigin' value="{{json_encode($campaign->leadsByOrigin->toArray())}}">
@endsection

@section('script')
<script src="https://cdn.amcharts.com/lib/5/index.js"></script>
<script src="https://cdn.amcharts.com/lib/5/percent.js"></script>
<script src="https://cdn.amcharts.com/lib/5/themes/Animated.js"></script>
<script src="{{asset('assets/js/datepicker/date-picker/datepicker.js')}}"></script>
<script src="{{asset('assets/js/datepicker/date-picker/datepicker.pt.js')}}"></script>
<script src="{{asset('assets/js/datepicker/date-picker/datepicker.custom.js')}}"></script>



<script>

    function copyText(id, url) {
        navigator.clipboard.writeText(url);
        //alert($('#' + id).text());
        $('#' + id).text('texto copiado!');
        $('#' + id).removeClass('btn-primary');
        $('#' + id).addClass('btn-success');

        setInterval(() => {
            $('#' + id).text('Copiar Link');
            $('#' + id).addClass('btn-primary');
            $('#' + id).removeClass('btn-success');

        }, 1500);

        //setInterval(copyTimer(id), 2000);
    }


    am5.ready(function() {
        var root = am5.Root.new("chartdiv");
        root.setThemes([am5themes_Animated.new(root)]);
        var chart = root.container.children.push(am5percent.PieChart.new(root, {
            endAngle: 270
        }));
        var series = chart.series.push(
            am5percent.PieSeries.new(root, {
                valueField: "count",
                categoryField: "origin",
                endAngle: 270
            })
        );
        series.states.create("hidden", {
            endAngle: -90
        });
        series.data.setAll(JSON.parse($('#leadsByOrigin').val()));
        series.appear(1000, 100);

    });
</script>
@endsection
