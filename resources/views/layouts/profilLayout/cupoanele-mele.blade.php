@extends('layouts.profilLayout.sidebar_profil')
@section('content-profil')
    <div class="container" style="list-style: none;">
        <div class="col-md-9" id="DIVID" style="background-color: white; text-align: center">
            <div class="row">
                <h2>Cupoanele mele</h2>
                @if($puncte !== null)
                    <h3>Cupon de 5%</h3>
                    <?php $procent1 = ($puncte->nr_puncte / 100) * 100 ?>
                    <div class="progress">
                        <div class="progress-bar progress-bar-striped active" role="progressbar"
                             aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width:{{$procent1}}%">
                            {{ $puncte->nr_puncte }}/100
                        </div>
                    </div>
                    <h3>Cupon de 10%</h3>
                    <?php $procent2 = ($puncte->nr_puncte / 200) * 100 ?>
                    <div class="progress">
                        <div class="progress-bar progress-bar-striped active" role="progressbar"
                             aria-valuenow="40" aria-valuemin="0" aria-valuemax="200" style="width:{{ $procent2 }}%">
                            {{ $puncte->nr_puncte }}/200
                        </div>
                    </div>
                    <h3>Cupon de 30%</h3>
                    <?php $procent3 = ($puncte->nr_puncte / 500) * 100 ?>
                    <div class="progress">
                        <div class="progress-bar progress-bar-striped active" role="progressbar"
                             aria-valuenow="40" aria-valuemin="0" aria-valuemax="500" style="width:{{ $procent3 }}%">
                            {{ $puncte->nr_puncte }}/500
                        </div>
                    </div>

                    <h3>Cupoane active</h3>
                    @foreach($cupoane as $cupon)
                        <div class="col-sm-6 col-md-4">
                            <div class="thumbnail" style="border: 9px double rgba(29,75,255,0.4);border-radius: 30px 0px 0px 40px;">
                                <img style="width: 150px; height: 200px;"
                                     src={{ asset('/imagini/images_frontend/'.$cupon->valoare.'.jpg') }} alt="...">
                                <div class="caption">
                                    <h3>COD CUPON: <strong> {{ $cupon->cod_cupon }} </strong></h3>
                                    <p style="color: black">Cuponul ofera {{ $cupon->valoare }}% la valoarea unei
                                        comenzi. Reducerea nu se aplica produselor inchiriate.</p>
                                    <hr>
                                    <p style="color: black; font-size: medium">Acest cupon expiră la data:
                                        <br>{{ $cupon->expira_la }}</p>
                                </div>
                                <?php $days = \App\Http\Controllers\Controller::getDaysBetweenTwoDates(\Carbon\Carbon::now(), $cupon->expira_la);?>
                                @if($days < 3)
                                    <div class="card-footer text-muted" style="color: red">
                                        <strong>Grabeste-te! Mai sunt doar {{ round($days) }} zile</strong>
                                    </div>
                                @endif

                            </div>
                        </div>

                    @endforeach
                @else
                    <h3>Nu sunt asociate puncte de loialitate pe acest profil. Urmariti modalitatea de acumulare a
                        punctelor.</h3>
                @endif
            </div>
        </div>
    </div>
@endsection
