<div class="modal fade" id="detaliiProdus{{ $produs->id }}" tabindex="-1" role="dialog" aria-hidden="true" data-toggle="modal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header text-center" style="background-color: whitesmoke;">
                <h2 style="font-weight: normal; color: black;">{{ $produs->denumire }}</h2>
            </div>
            <div class="modal-body mx-3" style="text-align: center;">

                <div class="md-form mb-5">
                    <i class="fas fa-envelope prefix grey-text"></i>
                    <label data-error="wrong" data-success="right"><span style="color: dodgerblue; font-weight: bold;">General</span></label>
                </div>
                <hr>

                <div class="md-form mb-5">
                    <i class="fas fa-envelope prefix grey-text"></i>
                    <label data-error="wrong" data-success="right"><span style="font-weight: bold; color: black">Id produs:</span> {{ $produs->id }}</label>
                </div>

                <div class="md-form mb-4">
                    <i class="fas fa-lock prefix grey-text"></i>
                    <label data-error="wrong" data-success="right" > <span style="font-weight: bold; color: black">Furnizor: </span>{{ $produs->furnizor->denumire_furnizor }}</label>
                </div>

                <div class="md-form mb-4">
                    <i class="fas fa-lock prefix grey-text"></i>
                    <label data-error="wrong" data-success="right" ><span style="font-weight: bold; color: black">Categorie: </span>{{ $produs->categorie->denumire }}</label>
                </div>

                <div class="md-form mb-4">
                    <i class="fas fa-lock prefix grey-text"></i>
                    <label data-error="wrong" data-success="right" ><span style="font-weight: bold; color: black">Cod produs: </span>{{ $produs->cod_produs }}</label>
                </div>
                <div class="md-form mb-4">
                    <i class="fas fa-lock prefix grey-text"></i>
                    <label data-error="wrong" data-success="right" ><span style="font-weight: bold; color: black">Descriere: </span>{{ $produs->descriere }}</label>
                </div>

                <div class="md-form mb-4">
                    <i class="fas fa-lock prefix grey-text"></i>
                    <label data-error="wrong" data-success="right" ><span style="font-weight: bold; color: black">Pret: </span>{{ $produs->pret_unitar }}</label>
                </div>

                <div class="md-form mb-4">
                    <i class="fas fa-lock prefix grey-text"></i>
                    <label data-error="wrong" data-success="right" ><span style="font-weight: bold; color: black">Imagine: </span>
                        <img style="width:6rem; height:6rem;" src="{{ asset('/uploads/produse/'.$produs->imagine) }}  ">
                    </label>
                </div>

                <div class="md-form mb-4">
                    <i class="fas fa-lock prefix grey-text"></i>
                    <label data-error="wrong" data-success="right" ><span style="font-weight: bold; color: black">Pret inchiriere ora: </span>{{ $produs->pret_inchiriere_ora }} </label>
                </div>

                <div class="md-form mb-4">
                    <i class="fas fa-lock prefix grey-text"></i>
                    <label data-error="wrong" data-success="right" ><span style="font-weight: bold; color: black">Pret inchiriere zi: </span>{{ $produs->pret_inchiriere_zi }} </label>
                </div>
                <hr>

                @if($produs->specificatie !==null)
                <div class="md-form mb-5">
                    <i class="fas fa-envelope prefix grey-text"></i>
                    <label data-error="wrong" data-success="right"><span style="color: dodgerblue; font-weight: bold;">Specificatii tehnice</span></label>
                </div>
                <hr>


                    <div class="md-form mb-4">
                        <i class="fas fa-lock prefix grey-text"></i>
                        <label data-error="wrong" data-success="right" ><span style="font-weight: bold; color: black">Culoare: </span>{{ $produs->specificatie->culoare }}</label>
                        <label data-error="wrong" data-success="right" ><span style="font-weight: bold; color: black">Material: </span>{{ $produs->specificatie->material }}</label>
                        <label data-error="wrong" data-success="right" ><span style="font-weight: bold; color: black">Stoc: </span>{{ $produs->specificatie->stoc }}</label>
                        <label data-error="wrong" data-success="right" ><span style="font-weight: bold; color: black">Greutate: </span>{{ $produs->specificatie->greutate }} {{ $produs->specificatie->unitate_masura_greutate }}</label>
                        <label data-error="wrong" data-success="right" ><span style="font-weight: bold; color: black">Dimensiuni:
                            </span>{{ $produs->specificatie->lungime }} x {{ $produs->specificatie->latime }} x {{ $produs->specificatie->inaltime }} {{ $produs->specificatie->unitate_masura }}
                        </label>
                            <hr>
                    </div>
                @endif

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal" style="background-color: whitesmoke; color: black;">Inchide</button>
            </div>
        </div>
    </div>
</div>
