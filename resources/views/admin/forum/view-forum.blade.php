@extends('layouts.adminLayout.admin_page');
@section('content')
    <?php
    use App\Http\Controllers\Controller;
    use App\IntrebareForum;
    $intrebari = Controller::getIntrebariForumInterval();
    ?>
    <div id="content">
        <div id="content-header">
            <h1>Intrebari pe forum</h1>
        </div>
        <div class="container-fluid">
            @if(Session::has('modificare_cu_succes'))
                <div class="alert alert-success alert-dismissible show" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                    <strong>{!! session('modificare_cu_succes') !!}</strong>
                </div>
            @endif
            <div class="row-fluid">
                <div class="span12">
                    <div class="widget-box">
                        <div class="container-fluid">
                            <div class="row-fluid">
                                <div class="span12">
                                    <div class="widget-box">
                                        <div class="widget-title"><span class="icon"><i class="icon-th"></i></span>
                                            <h5>Vizualizeaza intrebari existente</h5>
                                        </div>
                                        <div class="widget-content nopadding">
                                            <table class="table table-bordered data-table" id="table-forum">
                                                <thead>
                                                <tr>
                                                    <th>Utilizator</th>
                                                    <th>Data</th>
                                                    <th>Titlu</th>
                                                    <th>Intrebare</th>
                                                    <th>Nr raspunsuri</th>
                                                    <th>Raspunde</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <tr class="gradeX">
                                                    @foreach($intrebari as $intrebare)
                                                        @if($intrebare->id_user === 0)
                                                            <td>Neinregistrat</td>
                                                        @else
                                                            <td>{{ $intrebare->utilizator->nume}} {{ $intrebare->utilizator->prenume }}</td>
                                                        @endif
                                                        <td>{{ $intrebare->created_at }}</td>
                                                        @if($intrebare->titlu !== null)
                                                            <td>{{ $intrebare->titlu }}</td>
                                                        @endif
                                                       <td>{{ $intrebare->continut }}</td>
                                                        <td style="background-color: red; color: white; text-align: center">
                                                            <?php $nrRaspunsuri = IntrebareForum::where(['id_parinte' => $intrebare->id])->count();?>
                                                            {{ $nrRaspunsuri }}
                                                        </td>
                                                        <td style="background-color: darkgrey; color: black; text-align: center">
                                                            <a href="{{ url('/admin/raspunde-intrebare/'.$intrebare->id) }}"
                                                               class="btn btn-warning btn-mini">Raspunde</a></td>
                                                </tr>
                                                @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
