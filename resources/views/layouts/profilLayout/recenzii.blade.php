@extends('layouts.profilLayout.sidebar_profil')
@section('content-profil')
    <div class="container" style="list-style: none;">
        <div class="col-md-9" id="DIVID" style="background-color: white; text-align: center">
            <div class="row">
                <h2>Recenziile mele</h2>
                @if(!$recenzii->isEmpty())
                <?php $count = 1; ?>
                <table class="table">
                    <thead class="thead-dark">
                    <tr style="color: white">
                        <th scope="col">#</th>
                        <th scope="col">Produs</th>
                        <th scope="col">Titlu</th>
                        <th scope="col">Nota</th>
                    </tr>
                    </thead>
                    <tbody style="text-align: left;">
                    @foreach($recenzii as $recenzie)
                        <tr>
                            <th scope="row"><?php echo $count; ?></th>
                            <td>{{ $recenzie->produs->denumire }}  <img src="/uploads/produse/{{ $recenzie->produs->imagine }}" style="width: 50px; height: 50px;"></td>
                            <td>{{ $recenzie->titlu }}</td>
                            <td>{{ $recenzie->nota }}</td>
                        </tr>
                        <?php $count++; ?>
                    @endforeach
                    </tbody>
                </table>
                @else
                    <h3>Nu ati adaugat inca nici o recenzie</h3>
                @endif
            </div>
        </div>
    </div>
@endsection
