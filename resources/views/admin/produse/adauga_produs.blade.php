@extends('layouts.adminLayout.admin_page');
@section('content')
    <div id="content">
        <div id="content-header">
            <h1>Adauga produs</h1>
        </div>
        <div class="container-fluid">
            <div class="row-fluid">
                <div class="span12">
                    <div class="widget-box">
                        <div class="widget-title"> <span class="icon"> <i class="icon-info-sign"></i> </span>
                            <h5>Adauga produs</h5>
                        </div>
                        @if(Session::has('modificare_cu_succes'))
                            <div class="alert alert-success alert-dismissible show" role="alert">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                <strong>{!! session('modificare_cu_succes') !!}</strong>
                            </div>
                        @endif
                        <div class="widget-content nopadding">
                            <form class="form-horizontal" method="post" action="{{url('/admin/adauga-produs')}}" name="adauga-produs" id="adauga-produs"
                            enctype="multipart/form-data">{{csrf_field()}}

                                <div class="control-group">
                                    <label class="control-label">Categoria produsului</label>
                                    <div class="controls">
                                       <div class="select2-container" id="s2id_autogen1">
                                           <select name="categorie_produs" id="categorie_produs" style="width: 205px;">
                                               <?php echo $select; ?>
                                           </select>

                                       </div>
                                    </div>
                                </div>

                                <div class="control-group">
                                    <label class="control-label">Furnizorul produsului</label>
                                    <div class="controls">
                                        <div class="select2-container" id="s2id_autogen1">
                                            <select name="furnizor_produs" id="furnizor_produs" style="width: 205px;">
                                                <?php echo $selectFurnizor; ?>
                                            </select>

                                        </div>
                                    </div>
                                </div>

                                <div class="control-group">
                                    <label class="control-label">Cod produs</label>
                                    <div class="controls">
                                        <input type="text" name="cod_produs" id="cod_produs" />
                                        @if($errors->has('cod_produs'))
                                            <div class="error" style="color: red;">{{ $errors->first('cod_produs') }}</div>
                                        @endif
                                        <span id="alertResponse"></span>
                                    </div>
                                </div>


                                <div class="control-group">
                                    <label class="control-label">Denumire</label>
                                    <div class="controls">
                                        <input type="text" name="denumire_produs" id="denumire_produs" />
                                        <span id="alertResponse"></span>
                                    </div>
                                </div>

                                <div class="control-group">
                                    <label class="control-label">Descriere</label>
                                    <div class="controls">
                                        <textarea name="descriere_produs" id="descriere_produs"></textarea>
                                        <span id="alertResponse"></span>
                                    </div>
                                </div>


                                <div class="control-group">
                                    <label class="control-label">Pret unitar</label>
                                    <div class="controls">
                                        <input type="text" name="pret_produs" id="pret_produs"/>
                                        <span id="alertResponse"></span>
                                    </div>
                                </div>

                                <div class="control-group">
                                    <label class="control-label">Imaginea produsului</label>
                                    <div class="controls">
                                        <input type="file" name="imagine_produs" id="imagine_produs"/>
                                        <span id="alertResponse"></span>
                                    </div>
                                </div>

                                <div class="control-group">
                                    <label class="control-label">Pretul de inchiriere pe ora</label>
                                    <div class="controls">
                                        <input type="text" name="pret_ora_produs" id="pret_ora_produs"/>
                                        <span id="alertResponse"></span>
                                    </div>
                                </div>

                                <div class="control-group">
                                    <label class="control-label">Pretul de inchiriere pe zi</label>
                                    <div class="controls">
                                        <input type="text" name="pret_zi_produs" id="pret_zi_produs/">
                                        <span id="alertResponse"></span>
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
