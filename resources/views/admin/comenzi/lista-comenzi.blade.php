@extends('layouts.adminLayout.admin_page')
@section('content')
    <div id="content">
        <div id="content-header">
            <h1>Lista de comenzi</h1>
        </div>

        <div class="container-fluid" style="text-align: center">
            <div class="control-group">
                <h3>Filtreaza rezultate</h3>
                <div class="controls">
                    <div class="select2-container" id="s2id_autogen1">
                        <select name="filter_comenzi" id="filter_comenzi" style="width: 205px;">
                            <option value="all" attr="all" selected>Toate</option>
                            <option disabled="disabled">------Modalitate de plata------</option>
                            <option value="online" attr="modalitate_plata">Online</option>
                            <option value="cash" attr="modalitate_plata">COD</option>
                            <option disabled="disabled">------Statusul comenzii------</option>
                            <option value="In procesare" attr="status">In procesare</option>
                            <option value="Platita" attr="status">Platita</option>
                            <option value="In depozit" attr="status">In depozit</option>
                        </select>
                    </div>
                </div>
            </div>

            <hr>
            <div class="row-fluid">
                <div class="span12">
                    <div class="widget-box">
                        <div class="widget-title"><span class="icon"><i class="icon-th"></i></span></div>
                        <div class="widget-content nopadding">
                            <table class="table table-bordered data-table" id="comenzi-table">
                                <thead>
                                <tr>
                                    <th>NrComanda</th>
                                    <th>Status</th>
                                    <th>Data</th>
                                    <th>Modalitate plata</th>
                                    <th>Total</th>
                                    <th>Detalii</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($comenzi as $comanda)
                                    <tr class="gradeX">
                                        <td id="nrComanda">{{ $comanda->nr_comanda }}</td>
                                        <td id="status">{{ $comanda->status }}</td>
                                        <td id="data">{{ $comanda->created_at }}</td>
                                        <td id="plata">{{ $comanda->modalitate_plata }}</td>
                                        <td id="total">{{ $comanda->total }} RON</td>
                                        <td><a href="/admin/comanda/{{$comanda->id}}" class="btn btn-primary">Detalii</a></td>
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
