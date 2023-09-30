@extends('layouts.adminLayout.admin_page')
@section('content')
    <meta name="_token" content="{!! csrf_token() !!}" />
    <div id="content">
        <div id="content-header">
            <h1>Vizualizeaza produse</h1>
        </div>

        @if(Session::has('modificare_cu_succes'))
            <div class="alert alert-success alert-dismissible show" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <strong>{!! session('modificare_cu_succes') !!}</strong>
            </div>
        @endif

        <div class="alert alert-success alert-dismissible show" role="alert" id="responsecheckbox" style="visibility: hidden">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <strong>Modificare cu succes</strong>
        </div>

        <div class="container-fluid">
            <hr>
            <div class="row-fluid">
                <div class="span12">
                    <div class="widget-box">
                        <div class="widget-title"> <span class="icon"><i class="icon-th"></i></span>
                            <h5>Vizualizeaza produse</h5>
                        </div>
                        <div class="widget-content nopadding">
                            <table class="table table-bordered data-table">
                                <thead>
                                <tr>
                                    <th>Id produs</th>
                                    <th>Furnizor</th>
                                    <th>Categorie</th>
                                    <th>Denumire</th>
                                    <th>Pret</th>
                                    <th>Imagine</th>
                                    <th style="width: 2%;">De inchiriat</th>
                                    <th>Operatii</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($produse as $produs)
                                        <tr class="gradeX">
                                            <td>{{ $produs->id }}</td>
                                            <td>{{ $produs->furnizor->denumire_furnizor ?? '' }}</td>
                                            <td>{{$produs->categorie->denumire}}</td>
                                            <td>{{ $produs->denumire }}</td>
                                            <td>{{ $produs->pret_unitar }}</td>
                                            <td style="text-align: center;">
                                                @if(!empty($produs->imagine))
                                                    <img style="width:2rem; height:2rem;" src="{{ asset('/uploads/produse/'.$produs->imagine) }}  ">
                                                @endif
                                            </td>
                                            <td>
                                                <input type="checkbox" name="de_inchiriat" id="de_inchiriat" relId="{{$produs->id}}" value="1"
                                                       @if($produs->de_inchiriat === 1) checked @endif/>

                                            </td>
                                            <td class="center" style="width: 350px;">
                                                <a class="btn btn-info btn-mini" data-toggle="modal" href="#detaliiProdus{{ $produs->id }}">Vizualizare detalii</a>
                                                <a class="btn btn-warning btn-mini" href="{{ url('/admin/editeaza-produs/'.$produs->id) }}">Editare</a>
                                                <a relId="{{ $produs->id }}" relS="sterge-produs" href="javascript:" class="btn btn btn-danger btn-mini stergeProdus"
                                                   id="stergeProdus">Stergere</a>
                                                <a class="btn btn-success btn-mini" href="{{ url('/admin/produs/adauga-specificatii/'.$produs->id) }}">Adauga Specificatii</a>
                                            </td>
                                        </tr>
                                        @include('admin.produse.detalii_produs_modal')
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

