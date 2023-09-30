@extends('layouts.adminLayout.admin_page');
@section('content')
    <div id="content">
        <div id="content-header">
            <h1>Adauga furnizor</h1>
        </div>
        <div class="container-fluid">
            <div class="row-fluid">
                <div class="span12">
                    <div class="widget-box">
                        <div class="widget-title"> <span class="icon"> <i class="icon-info-sign"></i> </span>
                            <h5>Adauga furnizor</h5>
                        </div>
                        @if(Session::has('modificare_cu_succes'))
                            <div class="alert alert-success alert-dismissible show" role="alert">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                <strong>{!! session('modificare_cu_succes') !!}</strong>
                            </div>
                        @endif
                        <div class="widget-content nopadding">
                            <form class="form-horizontal" method="post" action="{{url('/admin/editeaza-furnizor/'.$furnizorSelectat->id)}}" name="adauga-furnizor" id="adauga-furnizor">{{csrf_field()}}

                                <div class="control-group">
                                    <label class="control-label">Denumirea/compania furnizorului</label>
                                    <div class="controls">
                                        <input type="text" name="denumire" id="denumire" value="{{ $furnizorSelectat->denumire_furnizor }}"/>
                                        <span id="alertResponse"></span>
                                    </div>
                                </div>

                                <div class="control-group">
                                    <label class="control-label">Persoana de contact</label>
                                    <div class="controls">
                                        <input type="text" name="contact" id="contact" value="{{ $furnizorSelectat->persoana_contact }}" />
                                    </div>
                                </div>

                                <div class="control-group">
                                    <label class="control-label">Email</label>
                                    <div class="controls">
                                        <input type="text" name="email" id="email" value="{{ $furnizorSelectat->email }}" />
                                    </div>
                                </div>

                                <div class="control-group">
                                    <label class="control-label">Telefon</label>
                                    <div class="controls">
                                        <input type="text" name="telefon" id="telefon" value="{{ $furnizorSelectat->telefon }}"/>
                                    </div>
                                </div>

                                <div class="control-group">
                                    <label class="control-label">Adresa</label>
                                    <div class="controls">
                                        <input type="text" name="adresa" id="adresa" value="{{ $furnizorSelectat->adresa }}"/>
                                    </div>
                                </div>

                                <div class="control-group">
                                    <label class="control-label">Oras</label>
                                    <div class="controls">
                                        <input type="text" name="oras" id="oras" value="{{ $furnizorSelectat->oras }}"/>
                                    </div>
                                </div>


                                <div class="form-actions">
                                    <input type="submit" value="Adauga" class="btn btn-success">
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
@endsection
