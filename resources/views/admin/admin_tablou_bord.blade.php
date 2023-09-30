@extends('layouts.adminLayout.admin_page')
@section('content')
    <!--main-container-part-->
    <div id="content">
        <!--Chart-box-->
        <div class="row-fluid">
            <div class="widget-box">
                <div class="widget-content">
                    <div class="row-fluid">
                        <div class="span3" style="text-align: center">
                            <h4>STATISTICI</h4>
                            <ul class="site-stats">
                                <li class="bg_lh"><i class="icon-user"></i>
                                    <div id="spanalert">{{ $nrUsers }}</div>
                                    <small>Total Utilizatori</small></li>
                                <li class="bg_db"><i class="icon-plus"></i>
                                    <div id="spanalert">{{ $nrComenziAzi }}</div>
                                    <small>Comenzi azi </small></li>
                                <li class="bg_dg"><i class="icon-shopping-cart"></i>
                                    <div id="spanalert">{{ $nrCosuri }}</div>
                                    <small>Total Cos</small></li>
                                <li class="bg_ls"><i class="icon-tag"></i>
                                    <div id="spanalert">{{ $nrComenzi }}</div>
                                    <small>Total Comenzi</small></li>
                                <li class="bg_lv"><i class="icon-repeat"></i>
                                    <div id="spanalert">{{ $nrSolicitari }}</div>
                                    <small>Solicitari in asteptare</small></li>
                                <li class="bg_dy"><i class="icon-globe"></i>
                                    <div id="spanalert">{{ $nrComenziOnline }}</div>
                                    <small>Comenzi online</small></li>
                            </ul>
                        </div>
                        <div class="span6" style="text-align: center">
                            @if(Session::has('modificare_cu_succes'))
                                <div class="alert alert-success alert-dismissible show" role="alert">
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                                            aria-hidden="true">&times;</span></button>
                                    <strong>{!! session('modificare_cu_succes') !!}</strong>
                                </div>
                            @endif
                            <h3>Importa date</h3>

                            <form action="{{ url('/admin/import-csv/produse') }}" method="post"
                                  enctype="multipart/form-data"> {{ csrf_field() }}
                                <h4>Importa csv pentru produse si specificatii tehnice</h4>
                                <input type="file" name="file-produse" accept="text/csv">
                                <br><br>
                                <input class="btn btn-success" type="submit" value="Incarca">
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <?php
            use Carbon\Carbon;
            use App\User;
            use App\Comanda;

            $dataPoints = array(
                array("y" => User::whereYear('created_at', Carbon::now()->year)->whereMonth('created_at', Carbon::now()->subMonth(6))->count(), "label" => Carbon::now()->subMonth(6)->format('F')),
                array("y" => User::whereYear('created_at', Carbon::now()->year)->whereMonth('created_at', Carbon::now()->subMonth(5))->count(), "label" => Carbon::now()->subMonth(5)->format('F')),
                array("y" => User::whereYear('created_at', Carbon::now()->year)->whereMonth('created_at', Carbon::now()->subMonth(4))->count(), "label" => Carbon::now()->subMonth(4)->format('F')),
                array("y" => User::whereYear('created_at', Carbon::now()->year)->whereMonth('created_at', Carbon::now()->subMonth(3))->count(), "label" => Carbon::now()->subMonth(3)->format('F')),
                array("y" => User::whereYear('created_at', Carbon::now()->year)->whereMonth('created_at', Carbon::now()->subMonth(2))->count(), "label" => Carbon::now()->subMonth(2)->format('F')),
                array("y" => User::whereYear('created_at', Carbon::now()->year)->whereMonth('created_at', Carbon::now()->subMonth(1))->count(), "label" => Carbon::now()->subMonth(1)->format('F')),
                array("y" => User::whereYear('created_at', Carbon::now()->year)->whereMonth('created_at', Carbon::now()->month)->count(), "label" => Carbon::now()->format('F')),
            );

            $c6 = $c = Comanda::select([DB::raw('count(id) as `count`'), DB::raw('sum(total) as `sum`'), DB::raw('DATE(created_at) as day')])->groupBy('day')->whereDate('created_at', '=', Carbon::today()->subDays(6))->first();
            if ($c6 === null) $c6 = 0; else $c6 = $c6->sum;
            $c5 = $c = Comanda::select([DB::raw('count(id) as `count`'), DB::raw('sum(total) as `sum`'), DB::raw('DATE(created_at) as day')])->groupBy('day')->whereDate('created_at', '=', Carbon::today()->subDays(5))->first();
            if ($c5 === null) $c5 = 0; else $c5 = $c5->sum;
            $c4 = $c = Comanda::select([DB::raw('count(id) as `count`'), DB::raw('sum(total) as `sum`'), DB::raw('DATE(created_at) as day')])->groupBy('day')->whereDate('created_at', '=', Carbon::today()->subDays(4))->first();
            if ($c4 === null) $c4 = 0; else $c4 = $c4->sum;
            $c3 = $c = Comanda::select([DB::raw('count(id) as `count`'), DB::raw('sum(total) as `sum`'), DB::raw('DATE(created_at) as day')])->groupBy('day')->whereDate('created_at', '=', Carbon::today()->subDays(3))->first();
            if ($c3 === null) $c3 = 0; else $c3 = $c3->sum;
            $c2 = $c = Comanda::select([DB::raw('count(id) as `count`'), DB::raw('sum(total) as `sum`'), DB::raw('DATE(created_at) as day')])->groupBy('day')->whereDate('created_at', '=', Carbon::today()->subDays(2))->first();
            if ($c2 === null) $c2 = 0; else $c2 = $c2->sum;
            $c1 = $c = Comanda::select([DB::raw('count(id) as `count`'), DB::raw('sum(total) as `sum`'), DB::raw('DATE(created_at) as day')])->groupBy('day')->whereDate('created_at', '=', Carbon::today()->subDays(1))->first();
            if ($c1 === null) $c1 = 0; else $c1 = $c1->sum;
            $c0 = $c = Comanda::select([DB::raw('count(id) as `count`'), DB::raw('sum(total) as `sum`'), DB::raw('DATE(created_at) as day')])->groupBy('day')->whereDate('created_at', '=', Carbon::today())->first();
            if ($c0 === null) $c0 = 0; else $c0 = $c0->sum;


            $dataPointsOrders = array(
                array("y" => $c0, "label" => Carbon::today()->format('D')),
                array("y" => $c1, "label" => Carbon::now()->subDays(1)->format('D')),
                array("y" => $c2, "label" => Carbon::now()->subDays(2)->format('D')),
                array("y" => $c3, "label" => Carbon::now()->subDays(3)->format('D')),
                array("y" => $c4, "label" => Carbon::now()->subDays(4)->format('D')),
                array("y" => $c5, "label" => Carbon::now()->subDays(5)->format('D')),
                array("y" => $c6, "label" => Carbon::now()->subDays(6)->format('D')),
            );

            $totalProductsSell = $total->cnt;

            $bestSellerPoints = array(
                array("label"=>$bestThreeSeller[0]->denumire, "y"=>($bestThreeSeller[0]->count/$totalProductsSell)*100),
                array("label"=>$bestThreeSeller[1]->denumire, "y"=>($bestThreeSeller[1]->count/$totalProductsSell)*100),
                array("label"=>$bestThreeSeller[2]->denumire, "y"=>($bestThreeSeller[2]->count/$totalProductsSell)*100)
            );

            ?>
            <div class="widget-box" style="margin-left: auto; width: 80%; margin-right: auto;">
                <script>
                    window.onload = function () {

                        var chart = new CanvasJS.Chart("chartContainer", {
                            title: {
                                text: "Dinamica utilizatorilor inregistrati in ultimele 6 luni"
                            },
                            axisY: {
                                title: "Numarul de utilizatori"
                            },
                            data: [{
                                type: "line",
                                dataPoints: <?php echo json_encode($dataPoints, JSON_NUMERIC_CHECK); ?>
                            }]
                        });
                        chart.render();

                        var chartOrders = new CanvasJS.Chart("chartContainerOrders", {
                            animationEnabled: true,
                            title: {
                                text: "Raport-valoarea totala a comenzilor pe zile din ultima saptamana"
                            },
                            axisY: {
                                title: "Valoarea totala",
                                suffix: " RON"
                            },
                            data: [{
                                type: "bar",
                                yValueFormatString: "#,##0 RON",
                                indexLabel: "{y}",
                                indexLabelPlacement: "inside",
                                indexLabelFontWeight: "bolder",
                                indexLabelFontColor: "white",
                                dataPoints: <?php echo json_encode($dataPointsOrders, JSON_NUMERIC_CHECK); ?>
                            }]
                        });
                        chartOrders.render();

                        var chartBestSeller = new CanvasJS.Chart("chartContainerBestSeller", {
                            theme: "light2",
                            animationEnabled: true,
                            title: {
                                text: "Raport-top 3 cele mai populare produse"
                            },
                            data: [{
                                type: "pie",
                                indexLabel: "{y}",
                                yValueFormatString: "#,##0.00\"%\"",
                                indexLabelPlacement: "inside",
                                indexLabelFontColor: "#36454F",
                                indexLabelFontSize: 18,
                                indexLabelFontWeight: "bolder",
                                showInLegend: true,
                                legendText: "{label}",
                                dataPoints: <?php echo json_encode($bestSellerPoints, JSON_NUMERIC_CHECK); ?>
                            }]
                        });
                        chartBestSeller.render();
                    }
                </script>

                </head>
                <body>
                <div id="chartContainer" style="height: 370px; width: 100%;"></div>
                <br> <br>
                <div id="chartContainerOrders" style="height: 370px; width: 100%;"></div>
                <br> <br>
                <div id="chartContainerBestSeller" style="height: 370px; width: 100%;"></div>
                <script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
                </body>
            </div>
        </div>
        <!--End-Chart-box-->
    </div>
    <!--end-main-container-part-->
@endsection
