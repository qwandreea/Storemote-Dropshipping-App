@extends('layouts.storeLayout.storemote_page')
@section('assets')
    <link rel="stylesheet" href="{{asset('css/css_frontend/forum.css')}}"/>
@endsection
@section('content')
    <?php
    use App\IntrebareForum;
    ?>
    <meta name="_token" content="{!! csrf_token() !!}" />
    <div class="container" style="list-style: none;">
        <div class="row bootstrap snippets">
            <div class="col-md-10 col-md-offset-1 col-sm-12">
                <div class="comment-wrapper">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            @if($intrebareForum->titlu === null)
                                Fara titlu. {{ $intrebareForum->continut }}
                            @else
                                {{ $intrebareForum->titlu }}.&nbsp;{{ $intrebareForum->continut }}
                            @endif
                        </div>
                        <div class="panel-body">
                            <input type="hidden" id="idParinte" value="{{ $intrebareForum->id }}">
                            <?php $userId = 0; ?>
                            @if(auth()->user())
                                <?php $userId = auth()->user()->id;?>
                            @endif
                            <input type="hidden" id="userId" value="{{ $userId }}">
                            <textarea class="form-control" id="textareacomment" placeholder="scrie un comentariu..."
                                      rows="3" required></textarea>
                            <br>
                            <button type="button" id="button-comenteaza" class="btn btn-info pull-right">Adauga</button>
                            <div class="clearfix"></div>
                            <hr>
                            <?php $raspunsuri = IntrebareForum::where('id_parinte', $intrebareForum->id)->orderBy('created_at', 'DESC')->get(); ?>
                            <ul class="media-list">
                                @foreach($raspunsuri as $raspuns)
                                    <li class="media">
                                        <a href="#" class="pull-left">
                                            @if($raspuns->id_user==0)
                                                <img src="{{asset('imagini/images_frontend/avatar-default.jpg')}}"
                                                     class="img-circle">
                                            @else
                                                <img src="{{asset('uploads/avatar/'.$raspuns->utilizator->imagine)}}"
                                                     class="img-circle">
                                                @if($raspuns->utilizator->admin === 1)
                                                    <strong class="text-success">DE LA ADMINISTRATOR</strong>
                                                @endif
                                            @endif
                                        </a>
                                        <div class="media-body">
                                <span class="text-muted pull-right">
                                    <small class="text-muted">{{$raspuns->created_at->diffForHumans()}}</small>
                                </span>
                                            <p style="color: black">
                                                {{$raspuns->continut}}
                                            </p>
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>

            </div>
        </div>

    </div>
@endsection
