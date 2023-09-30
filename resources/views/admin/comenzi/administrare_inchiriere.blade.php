@extends('layouts.adminLayout.admin_page')
@section('content')
    <meta name="_token" content="{!! csrf_token() !!}" />
    <div id="content">
        <div id="content-header">
            <h1>Vizualizeaza solicitarile de inchiriere produse</h1>

            @if(Session::has('modificare_cu_succes'))
                <div class="alert alert-success alert-dismissible show" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                    <strong>{!! session('modificare_cu_succes') !!}</strong>
                </div>
            @endif

        </div>
        <div class="container-fluid">
            <hr>
            <div class="row-fluid">
                <div class="span12">
                    <div class="widget-box">
                        <div class="widget-title"><span class="icon"><i class="icon-th"></i></span>
                            <h5>Vizualizeaza solicitarile</h5>
                        </div>
                        <div class="widget-content nopadding">
                            <table class="table table-bordered data-table">
                                <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>Id produs</th>
                                    <th>Id utilizator</th>
                                    <th>Data inceput</th>
                                    <th>Data sfarsit</th>
                                    <th>Tip de plata</th>
                                    <th>Cantitate</th>
                                    <th>Subtotal</th>
                                    <th>Modificare status</th>
                                    <th>Data solicitarii</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($solicitari as $solicitare)
                                    <tr class="gradeX">
                                        <td>{{ $solicitare->id }}</td>
                                        <td>{{$solicitare->produs_id}}</td>
                                        <td>{{ $solicitare->utilizator_id }}</td>
                                        <td>{{ $solicitare->data_inceput }}</td>
                                        <td>{{ $solicitare->data_sfarsit }}</td>
                                        <td>{{ $solicitare->tip }}</td>
                                        <td>{{ $solicitare->cantitate }}</td>
                                        <td>{{ $solicitare->subtotal }}</td>
                                        <td>
                                            @if($solicitare->status === 'In asteptare')
                                                <select name="status" id="status" relId="{{ $solicitare->id }}">
                                                    <option value="In asteptare" selected disabled>{{ $solicitare->status }}</option>
                                                    <option value="Acceptat">Acceptat</option>
                                                    <option value="Respins">Respins</option>
                                                    @elseif($solicitare->status == 'Acceptat')
                                                        <div style="background-color: lawngreen; color: black;">
                                                            Acceptat
                                                        </div>
                                                    @else
                                                        <div style="background-color: red; color: black;">Respins</div>
                                                    @endif
                                                </select>
                                        </td>
                                        <td>{{ $solicitare->created_at }}</td>
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
