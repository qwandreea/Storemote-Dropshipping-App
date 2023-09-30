@extends('layouts.adminLayout.admin_page')

@section('content')
    <div id="content">
        <div id="content-header">
            <h1>Setari parola</h1>
            @if(Session::has('admin_error_change'))
                <div class="alert alert-error alert-dismissible show" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <strong>{!! session('admin_error_change') !!}</strong>
                </div>
            @endif
            @if(Session::has('admin_success_change'))
                <div class="alert alert-success alert-dismissible show" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <strong>{!! session('admin_success_change') !!}</strong>
                </div>
            @endif
        </div>
        <div class="container-fluid">
                <div class="row-fluid">
                    <div class="span12">
                        <div class="widget-box">
                            <div class="widget-title"> <span class="icon"> <i class="icon-info-sign"></i> </span>
                                <h5>Modificare parola</h5>
                            </div>
                            <div class="widget-content nopadding">
                                <form class="form-horizontal" method="post" action="{{url('admin/schimba-parola')}}" name="password_validate" id="password_validate" novalidate="novalidate">{{csrf_field()}}

                                    <div class="control-group">
                                        <label class="control-label">Parola</label>
                                        <div class="controls">
                                            <input type="password" name="parola" id="parola" />
                                            <span id="alertResponse"></span>
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <label class="control-label">Parola noua</label>
                                        <div class="controls">
                                            <input type="password" name="parola_noua" id="parola_noua" />
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <label class="control-label">Confirma parola</label>
                                        <div class="controls">
                                            <input type="password" name="parola_noua_confirm" id="parola_noua_confirm" />
                                        </div>
                                    </div>
                                    <div class="form-actions">
                                        <input type="submit" value="Salvare" class="btn btn-success">
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
