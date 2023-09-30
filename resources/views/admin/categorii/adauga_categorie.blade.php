@extends('layouts.adminLayout.admin_page');
@section('content')
    <div id="content">
        <div id="content-header">
            <h1>Adauga categorie</h1>
        </div>
        <div class="container-fluid">
            <div class="row-fluid">
                <div class="span12">
                    <div class="widget-box">
                        <div class="widget-title"> <span class="icon"> <i class="icon-info-sign"></i> </span>
                            <h5>Adauga categorii de produse</h5>
                        </div>
                        <div class="widget-content nopadding">
                            <form class="form-horizontal" method="post" action="{{url('/admin/adauga-categorie')}}" name="adauga-categorie" id="adauga-categorie">{{csrf_field()}}

                                <div class="control-group">
                                    <label class="control-label">Selectati tipul de categorie</label>
                                    <div class="controls">
                                        <select name="tip_categorie" style="width: 205px;">
                                            <option value="0">Categorie principala</option>
                                            @foreach($parinte as $value)
                                                <option value="{{$value->id}}">{{$value->denumire}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="control-group">
                                    <label class="control-label">Denumire</label>
                                    <div class="controls">
                                        <input type="text" name="denumire" id="denumire" />
                                        <span id="alertResponse"></span>
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label">Descriere</label>
                                    <div class="controls">
                                        <textarea name="descriere" id="descriere" ></textarea>
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label">Adresa URL</label>
                                    <div class="controls">
                                        <input type="text" name="adr_url" id="adr_url" />
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
