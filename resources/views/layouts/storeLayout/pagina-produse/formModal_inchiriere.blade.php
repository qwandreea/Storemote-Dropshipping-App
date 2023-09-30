<div id="test">
    <div class="modal fade modalBind" id="formModal{{ $produs->id }}" tabindex="-1" role="dialog" aria-hidden="true"
         data-toggle="modal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header text-center" style="background-color: #886f4a;">
                    <h2 style="font-weight: normal; color: black;">Formular de solicitare</h2>
                </div>
                <form name="form-solicitare" id="myform"> {{ csrf_field() }}
                    <?php use App\Produs; $produs = Produs::where('id', $produs->id)->first(); $maxStoc = $produs->specificatie->stoc;?>
                    <div class="modal-body mx-3" id="modal-body" style="text-align: center;">
                        <input type="hidden" id="id{{ $produs->id }}" name="id" value="{{ $produs->id }}">
                        <div class="md-form mb-5">
                            <label for="dataInceput" data-error="wrong" data-success="right">Data de inceput</label>
                            <?php
                            $datetime = new DateTime();
                            $datetime->modify('+3 day');
                            $timezone = new DateTimeZone('Europe/Bucharest');
                            $datetime->setTimezone($timezone);
                            $startDate = $datetime->format('Y-m-d\TH:i:s');?>

                            <input type="datetime-local" name="dataInceput" id="dataInceput{{$produs->id}}"
                                   value="<?php echo $startDate; ?>" min="<?php echo $startDate;?>"/>
                        </div>
                        <hr>
                        <div class="md-form mb-5">
                            <label for="dataSfarsit" data-error="wrong" data-success="right">Data de returnare</label>
                            <input type="datetime-local" name="dataSfarsit" id="dataSfarsit{{$produs->id}}"
                                   min="<?php echo $startDate;?>"/>
                        </div>
                        <p style="color: red;">Completati si intervalul orar</p>
                        <hr>

                        <div class="md-form mb-5">
                            <label for="select-tip" data-error="wrong" data-success="right">Tip de plata</label>
                            <select id="select-tip" class="select-tip{{$produs->id}}" name="select-tip"
                                    data="<?php echo $produs->id; ?>">
                                <option disabled selected value="default">Selectati tipul de plata..</option>
                                <option value="zi">Plata zi</option>
                                <option value="ora">Plata ora</option>
                            </select>
                        </div>
                        <hr>

                        <div class="md-form mb-5">
                            <label for="cantitate" data-error="wrong" data-success="right">Cantitate </label>
                            <input type="number" name="cantitate" id="cantitate{{ $produs->id }}" min="1"
                                   max="<?php echo $maxStoc ?>" value="1">
                        </div>

                    </div>

                    <div class="modal-footer">
                        <div class="md-form mb-5">
                            <h3 data-error="wrong" data-success="right" id="total{{$produs->id}}">TOTAL </h3>
                            <input type="hidden" id="subtotal{{$produs->id}}" name="subtotal">
                            <input type="hidden" id="pretCuTip{{$produs->id}}" name="pretcutip">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" id="submit" class="btn btn-success">Trimite</button>
                        <button type="button" class="btn btn-danger" data-dismiss="modal"
                                style="color: black;">Inchide
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


