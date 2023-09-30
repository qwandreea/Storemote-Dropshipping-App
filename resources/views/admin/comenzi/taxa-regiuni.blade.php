@extends('layouts.adminLayout.admin_page')
@section('content')
    <meta name="_token" content="{!! csrf_token() !!}" />
    <div id="content">
        <div id="content-header">
            <h1>Gestiune taxe regiuni</h1>
            @if(Session::has('modificare_cu_succes'))
                <div class="alert alert-success alert-dismissible show" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <strong>{!! session('modificare_cu_succes') !!}</strong>
                </div>
            @endif
        </div>
        <div class="container-fluid">
            <hr>
            <div class="row-fluid">
                <div class="span12">
                    <div class="widget-box">
                        <div class="widget-title"> <span class="icon"><i class="icon-th"></i></span>
                            <h5>Vizualizeaza taxe</h5>
                        </div>
                        <div class="widget-content nopadding">
                            <table class="table table-bordered data-table">
                                <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>Cod regiune</th>
                                    <th>Denumire regiune</th>
                                    <th>Taxa</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($rezultate as $rezultat)
                                    <tr class="gradeX">
                                        <td style="width: 10%;">{{ $rezultat->id }}</td>
                                        <th style="width: 20%;">{{ $rezultat ->cod }}</th>
                                        <td style="width: 20%;">{{ $rezultat->denumire }}</td>
                                        <td style="width: 20%;">
                                            <input type="number" id="taxa" relId="{{ $rezultat->id }}" value="{{ $rezultat->taxa }}" min="0">
                                        </td>
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
@endsection
