@extends('layouts.adminLayout.admin_page');
@section('content')
    <div id="content">
        <div id="content-header">
            <h1>Raspunde la intrebare</h1>
        </div>

        <div class="container-fluid">
            <div class="row-fluid">
                <div class="span12">
                    <div class="widget-box">
                        <div class="widget-content nopadding">
                            <form class="form-horizontal" method="post" action="{{ url('/admin/raspunde-intrebare/'.$intrebare->id) }}" >{{csrf_field()}}
                                <div class="control-group">
                                    <div class="controls">
                                      <h4>{{ $intrebare->continut }}</h4>
                                    </div>
                                </div>
                                <hr>
                                <div class="control-group">
                                    <div class="controls">
                                        <label for="titl">Titlul</label>
                                       <input type="text" name="titlu">
                                    </div>
                                </div>
                                <div class="control-group">
                                    <div class="controls">
                                        <label for="titl">Raspuns</label>
                                        <textarea name="raspuns" required></textarea>
                                    </div>
                                </div>

                                <div class="form-actions">
                                    <input type="submit" value="Trimite" class="btn btn-success">
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
