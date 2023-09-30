@extends('layouts.adminLayout.admin_page');
@section('content')
    <div id="content">
        <div id="content-header">
            <h1>Promotii banner</h1>
        </div>
        <div class="container-fluid">

            <div class="row-fluid">
                <div class="span12">
                    <div class="widget-box">
                        <div class="widget-title"><span class="icon"> <i class="icon-info-sign"></i> </span>
                            <h5>Adauga promotii banner</h5>
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
                                  action="{{url('/admin/adauga-promotie/')}}"
                                  name="adauga-promotie" id="adauga-promotie"
                                  enctype="multipart/form-data">{{csrf_field()}}

                                <div class="control-group">
                                    <div class="container">
                                        <div>
                                            <input type="file" name="imagine" id="imagine" required/>
                                            <input type="text" name="titlu" id="titlu" placeholder="titlu" value=""
                                                   required/>
                                            <input type="text" name="mesaj" id="mesaj" placeholder="mesaj" value=""
                                                   required/>
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
                                                <h5>Vizualizeaza promotii existente</h5>
                                            </div>
                                            <div class="widget-content nopadding">

                                                <form action="{{ url('/admin/produs/editeaza-specificatii/') }}"
                                                      method="post">{{ csrf_field() }}
                                                    <table class="table table-bordered data-table">
                                                        <thead>
                                                        <tr>
                                                            <th>Imagine</th>
                                                            <th>Titlu</th>
                                                            <th>Mesaj promotional</th>
                                                            <th>Operatii</th>
                                                        </tr>
                                                        </thead>
                                                        <tbody>
                                                        @foreach($promotii as $promotie)
                                                            <tr class="gradeX">
                                                                <form
                                                                    action="{{ url('/admin/editeaza-promotie/'.$promotie->id) }} "
                                                                    method="post" enctype="multipart/form-data"
                                                                    name="editeaza-promotie"> {{ csrf_field() }}
                                                                    <td>
                                                                        <input type="file" name="banner">
                                                                        <img style="width: 20rem; height: 10rem;"
                                                                             src="{{ asset('/uploads/admin/'.$promotie->banner) }}">
                                                                    </td>
                                                                    <td><input type="text" name="titlu"
                                                                               value="{{ $promotie->titlu }}" required/>
                                                                    </td>
                                                                    <td><input type="text" name="mesaj"
                                                                               value="{{ $promotie->mesaj_promotie }}"
                                                                               required/></td>
                                                                    <td>
                                                                        <input type="submit" value="Modifica"
                                                                               class="btn btn-warning btn-mini"/>
                                                                        <a relId="{{ $promotie->id }}"
                                                                           relS="sterge-promotie" href="javascript:"
                                                                           class="btn btn btn-danger btn-mini stergePromotie"
                                                                           id="stergePromotie">Stergere</a>
                                                                </form>

                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                        </tbody>
                                                    </table>
                                                </form>
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
