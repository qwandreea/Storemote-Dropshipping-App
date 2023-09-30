@extends('layouts.adminLayout.admin_page')
@section('content')
    <div id="content">
        <div id="content-header">
            <h1>Vizualizeaza categorii</h1>
        </div>
        @if(Session::has('modificare_cu_succes'))
            <div class="alert alert-success alert-dismissible show" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <strong>{!! session('modificare_cu_succes') !!}</strong>
            </div>
        @endif
        <div class="container-fluid">
            <hr>
            <div class="row-fluid">
                <div class="span12">
                    <div class="widget-box">
                        <div class="widget-title"> <span class="icon"><i class="icon-th"></i></span>
                            <h5>Vizualizeaza categorii</h5>
                        </div>
                        <div class="widget-content nopadding">
                            <table class="table table-bordered data-table">
                                <thead>
                                <tr>
                                    <th>Id categorie</th>
                                    <th>Categorie subordonata</th>
                                    <th>Denumire</th>
                                    <th>Descriere</th>
                                    <th>Adresa URL</th>
                                    <th>Operatii</th>
                                </tr>
                                </thead>
                                <tbody>
                                    @foreach($categorii as $categorie)
                                        <tr class="gradeX">
                                            <td>{{ $categorie->id }}</td>
                                            <td>{{$categorie->id_parinte}}</td>
                                            <td>{{ $categorie->denumire }}</td>
                                            <td>{{ $categorie->descriere }}</td>
                                            <td>{{ $categorie->adr_url }}</td>
                                            <td class="center">
                                                <a href="{{ url('/admin/editeaza-categorie/'.$categorie->id) }}" class="btn btn-warning btn-mini">Editare</a>
                                                <a relId="{{ $categorie->id }}" relS="sterge-categorie" href="javascript:" class="btn btn btn-danger btn-mini stergeCategorie"
                                                   id="stergeCategorie">Stergere</a>
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
