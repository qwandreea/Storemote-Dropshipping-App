@extends('layouts.adminLayout.admin_page')
@section('content')
    <div id="content">
        <div id="content-header">
            <h1>Vizualizeaza furnizori</h1>
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
                            <h5>Vizualizeaza furnizori</h5>
                        </div>
                        <div class="widget-content nopadding">
                            <table class="table table-bordered data-table">
                                <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>Denumire furnizor</th>
                                    <th>Persoana de contact</th>
                                    <th>Email</th>
                                    <th>Telefon</th>
                                    <th>Adresa</th>
                                    <th>Oras</th>
                                    <th>Operatii</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($furnizori as $furnizor)
                                    <tr class="gradeX">
                                        <td>{{ $furnizor->id }}</td>
                                        <td>{{$furnizor->denumire_furnizor}}</td>
                                        <td>{{ $furnizor->persoana_contact }}</td>
                                        <td>{{ $furnizor->email }}</td>
                                        <td>{{ $furnizor->telefon }}</td>
                                        <td>{{ $furnizor->adresa }}</td>
                                        <td>{{ $furnizor->oras }}</td>
                                        <td class="center">
                                            <a href="{{ url('/admin/editeaza-furnizor/'.$furnizor->id) }}" class="btn btn-warning btn-mini">Editare</a>
                                            <a relId="{{ $furnizor->id }}" relS="sterge-furnizor" href="javascript:" class="btn btn btn-danger btn-mini stergeFurnizor" id="stergeFurnizor">Stergere</a>
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
