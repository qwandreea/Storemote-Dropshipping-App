
@extends('layouts.adminLayout.admin_page');
@section('content')
    <div id="content">
        <div id="content-header">
            <h1>Informatii de contact</h1>
            @if(Session::has('succes'))
                <div class="alert alert-success alert-dismissible show" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <strong>{!! session('succes') !!}</strong>
                </div>
            @endif
        </div>
        <div class="container-fluid">
            <div class="row-fluid">
                <div class="span12">
                    <div class="widget-box">
                        <div class="widget-title"> <span class="icon"> <i class="icon-info-sign"></i> </span>
                            <h5>Adauga categorii de produse</h5>
                        </div>
                        <div class="widget-content nopadding">
                            <form class="form-horizontal" method="post" action="{{url('/admin/informatii-contact')}}" name="informatii-contact" id="informatii-contact">{{csrf_field()}}

                                <input type="hidden" name="id" value="{{ $informatii->id }}">

                                <div class="control-group">
                                    <label class="control-label">Adresa</label>
                                    <div class="controls">
                                        <input type="text" name="adresa" id="adresa" value="{{ $informatii->adresa }}" required/>
                                        <span id="alertResponse"></span>
                                    </div>
                                </div>

                                <div class="control-group">
                                    <label class="control-label">Email contact</label>
                                    <div class="controls">
                                        <input type="text" name="email" id="email" value="{{ $informatii->email }}" required></input>
                                    </div>
                                </div>

                                <div class="control-group">
                                    <label class="control-label">Telefon contact</label>
                                    <div class="controls">
                                        <input type="text" name="telefon" id="telefon" value="{{ $informatii->telefon }}" required/>
                                    </div>
                                </div>

                                <div class="control-group">
                                    <label class="control-label">Skype contact</label>
                                    <div class="controls">
                                        <input type="text" name="skype" id="skype" value="{{ $informatii->skype }}" required/>
                                    </div>
                                </div>

                                <div class="form-actions">
                                    <input type="submit" value="Modifica" class="btn btn-success">
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
