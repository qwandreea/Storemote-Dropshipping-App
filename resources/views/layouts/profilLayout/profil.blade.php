@extends('layouts.profilLayout.sidebar_profil')
@section('content-profil')
            <div class="container" style="list-style: none;">
                <div class="col-md-6" id="DIVID" style="background-color: white;">
                    <div class="row">
                        <!-- left column -->
                        <form class="form-horizontal" role="form" action="/profil/{{$profilUtilizator->id}}" method="post" enctype="multipart/form-data"> {{ csrf_field() }}
                            <div class="col-md-3">
                                <div class="text-center">
                                    <img src="{{ asset('/uploads/avatar/'.$profilUtilizator->imagine) }}" class="avatar img-circle" alt="avatar">
                                    <h6>Încarcă altă imagine</h6>

                                    <input type="file" class="form-control" name="imagine">
                                </div>
                            </div>

                            <!-- edit form column -->
                            <div class="col-md-9 personal-info">
                                <h3>Informații personale</h3>

                                <div class="form-group">
                                    <label class="col-lg-3 control-label">Nume:</label>
                                    <div class="col-lg-20">
                                        <input class="form-control" type="text" name="nume" value=" {{ $profilUtilizator->nume }} " required>
                                    </div>

                                </div>
                                <div class="form-group">
                                    <label class="col-lg-3 control-label">Prenume:</label>
                                    <div class="col-lg-20">
                                        <input class="form-control" type="text" name="prenume" value=" {{ $profilUtilizator->prenume }} " required>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-lg-3 control-label">Telefon:</label>
                                    <div class="col-lg-20">
                                        <input class="form-control" type="text" name="telefon" value=" {{ $profilUtilizator->telefon }} " required>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-lg-3 control-label">Data nastere:</label>
                                    <div class="col-lg-20">
                                        <?php $date =  $profilUtilizator->data_nastere;?>
                                        <input class="form-control text-center"  type="date" name="data" value="<?php echo $date;?>"
                                               min="1950-01-01" max="2002-01-01">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-lg-3 control-label">Email:</label>
                                    <div class="col-lg-20">
                                        <input class="form-control" type="text" name="email" value="{{ $profilUtilizator->email }}" required>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-md-3 control-label">Parolă:</label>
                                    <div class="col-md-8">
                                        <input class="form-control" type="password" name="password">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-md-3 control-label">Confirmă parolă:</label>
                                    <div class="col-md-8">
                                        <input class="form-control" type="password" name="password_confirmation">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-md-3 control-label"></label>
                                    <div class="col-md-8">
                                        <input type="submit" value="Salvează" style="background-color: green; color: white; border-radius: 8px; height: 5vh;">
                                        <span></span>
                                        <input type="reset" class="btn btn-danger" id="btnclose" value="Închide" onclick="closeEdit()">
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <hr>
        </div>
    </div>
@endsection
