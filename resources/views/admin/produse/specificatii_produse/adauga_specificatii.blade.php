@extends('layouts.adminLayout.admin_page');
@section('content')
    <div id="content">
        <div id="content-header">
            <h1>Adauga specificatii tehnice pentru {{ $produs->denumire }}</h1>
        </div>
        <div class="container-fluid">

            <div class="row-fluid">
                <div class="span12">
                    <div class="widget-box">
                        <div class="widget-title"><span class="icon"> <i class="icon-info-sign"></i> </span>
                            <h5>Adauga specificatii tehnice</h5>
                        </div>
                        @if(Session::has('modificare_cu_succes'))
                            <div class="alert alert-success alert-dismissible show" role="alert">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                                        aria-hidden="true">&times;</span></button>
                                <strong>{!! session('modificare_cu_succes') !!}</strong>
                            </div>
                        @endif
                        <div class="widget-content nopadding">
                            <form class="form-horizontal" method="post"
                                  action="{{url('/admin/produs/adauga-specificatii/'.$produs->id)}}"
                                  name="adauga-produs-specificatii" id="adauga-produs-specificatii">{{csrf_field()}}
                                <input type="hidden" name="id_produs" value="{{ $produs->id }}">
                                <div class="control-group">
                                    <label class="control-label" style="font-weight: bold; color: green;">Id
                                        produs: {{ $produs->id }}</label>
                                </div>

                                <div class="control-group">
                                    <div class="container">
                                        <div>
                                            <input type="text" name="culoare[]" id="culoare" placeholder="culoare"
                                                   value="" required/>
                                            <input type="text" name="material[]" id="material" placeholder="material"
                                                   value="" required/>
                                            <input type="text" name="stoc[]" id="stoc" placeholder="stoc" value=""/>
                                            <input type="text" name="greutate[]" id="greutate" placeholder="greutate"
                                                   value="" required/>
                                            <input type="text" name="masura[]" id="masura"
                                                   placeholder="unitate de masura greutate" value="" required/>
                                            <input type="text" name="lungime[]" id="lungime" placeholder="lungime"
                                                   value=""/>
                                            <input type="text" name="latime[]" id="latime" placeholder="latime"
                                                   value=""/>
                                            <input type="text" name="inaltime[]" id="inaltime" placeholder="inaltime"
                                                   value=""/>
                                            <input type="text" name="unitate[]" id="unitate"
                                                   placeholder="unitate de masura dimensiuni" value=""/>
                                            <a href="javascript:bulkAdd;" class="adauga">
                                                <img src="{{ asset('/imagini/imagini_backend/icons/32/plus.png') }}"
                                                     style="width: 25px; height: 25px;"/>
                                            </a>
                                        </div>
                                    </div>
                                </div>



                                <div class="form-actions">
                                    <input type="submit" value="Adauga" class="btn btn-success">
                                </div>
                            </form>

                            <div class="container-fluid">
                                <hr>
                                <div class="row-fluid">
                                    <div class="span12">
                                        <div class="widget-box">
                                            <div class="widget-title"><span class="icon"><i class="icon-th"></i></span>
                                                <h5>Vizualizeaza specificatii</h5>
                                            </div>
                                            <div class="widget-content nopadding">

                                            @if($produs->specificatie !==null)
                                                    <form action="{{ url('/admin/produs/editeaza-specificatii/'.$produs->id) }}" method="post">{{ csrf_field() }}
                                                <table class="table table-bordered data-table">
                                                    <thead>
                                                    <tr>
                                                        <th>Id</th>
                                                        <th>Culoare</th>
                                                        <th>Material</th>
                                                        <th>Stoc</th>
                                                        <th>Greutate</th>
                                                        <th>Dimensiuni</th>
                                                        <th>Operatii</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    <tr class="gradeX">
                                                    <td>{{ $produs->specificatie->id}}</td>
                                                    <td><input type="text" name="culoare" value="{{ $produs->specificatie->culoare }}" required/></td>
                                                    <td><input type="text" name="material" value="{{ $produs->specificatie->material }}" required/></td>
                                                    <td><input type="text" name="stoc" value="{{ $produs->specificatie->stoc }}"/></td>
                                                    <td>{{ $produs->specificatie->id}} {{ $produs->specificatie->unitate_masura_greutate}}</td>
                                                    <td>{{ $produs->specificatie->lungime}}
                                                        x {{ $produs->specificatie->latime}}
                                                        x {{ $produs->specificatie->inaltime}} {{ $produs->specificatie->unitate_masura}}</td>
                                                    <td>
                                                        <input type="submit" value="Modifica" class="btn btn-warning btn-mini"/>
                                                        <a relId="{{ $produs->specificatie->id }}"
                                                           relS="produs/sterge-specificatii" href="javascript::"
                                                           class="btn  btn-danger btn-mini stergeSpecificatii"
                                                           id="stergeSpecificatii">Stergere</a>
                                                    </td>
                                                    </tr>
                                                    </tbody>
                                                </table>
                                                </form>
                                                @endif
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
    </div>
    </div>


@endsection
