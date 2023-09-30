@extends('layouts.storeLayout.storemote_page')
@section('assets')
    <link rel="stylesheet" href="{{asset('css/css_frontend/forum.css')}}"/>
@endsection
@section('content')
    <?php
    use App\Http\Controllers\Controller;
    use App\IntrebareForum;
    $intrebariForum = Controller::getIntrebariForumInterval();
    ?>
    <div class="container" style="list-style: none;">
        <h2>Întrebări și păreri de la utilizatori</h2>

        <ul class="media-list">
            @foreach($intrebariForum as $intrebareForum)
                <?php $nrRaspunsuri = IntrebareForum::where(['id_parinte'=>$intrebareForum->id])->count(); ?>
                <li class="media">
                    <div class="panel panel-default ">
                        <div class="panel-heading">
                            @if($intrebareForum->titlu !== null)
                                <h3 class="panel-title">{{ $intrebareForum->titlu }}</h3>
                            @else
                                <h3 class="panel-title">Fara titlu</h3>
                            @endif
                        </div>
                        <a href="#" class="pull-left">
                            @if($intrebareForum->id_user==0)
                                <img src="{{asset('imagini/images_frontend/avatar-default.jpg')}}"
                                     class="img-circle">
                            @else
                                <img src="{{asset('uploads/avatar/'.$intrebareForum->utilizator->imagine)}}"
                                     class="img-circle">
                            @endif
                        </a>
                        <div class="panel-body">
                            {{ $intrebareForum->continut }}
                        </div>
                        <div class="panel-footer" style="margin-top: 0">
                            <div class="pull-left">{{ $intrebareForum->created_at }}</div>
                            <a class="btn btn-default" href="{{ url('/forum/intrebare/'.$intrebareForum->id) }}">
                                Adauga comentariu <span class="badge">{{ $nrRaspunsuri }}</span>
                            </a>
                        </div>
                    </div>
                </li>
            @endforeach
        </ul>
    </div>
@endsection
