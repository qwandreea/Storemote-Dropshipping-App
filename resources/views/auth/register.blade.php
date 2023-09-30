@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card" style="margin-top: 0">
                    <div class="card-header" id="login-card">
                        <h2>Inregistrare cont utilizator</h2>
                    </div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('register') }}" aria-label="{{ __('Inregistrare') }}" enctype="multipart/form-data">
                            @csrf

                            <div class="form-group row">
                                <label for="calitate" id="label-email" class="col-md-5 col-form-label text-md-right">Formă de adresare:</label>
                                <label class="radio-inline pr-3 pt-2"><input type="radio" name="calitate" value="Dl" checked>Dl.</label>
                                <label class="radio-inline pt-2"><input type="radio" name="calitate" value="Dna">Dna.</label>
                            </div>

                            <div class="form-group row">
                                <label id="label-email" for="nume" class="col-md-4 col-form-label text-md-right">{{ __('Nume') }}</label>

                                <div class="col-md-6">
                                    <input id="nume" type="text" class="form-control{{ $errors->has('nume') ? ' is-invalid' : '' }}" name="nume" value="{{ old('nume') }}" required autofocus>

                                    @if ($errors->has('nume'))
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('nume') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row">
                                <label id="label-email" for="prenume" class="col-md-4 col-form-label text-md-right">{{ __('Prenume') }}</label>

                                <div class="col-md-6">
                                    <input id="prenume" type="text" class="form-control{{ $errors->has('prenume') ? ' is-invalid' : '' }}" name="prenume" value="{{ old('prenume') }}" required autofocus>

                                    @if ($errors->has('prenume'))
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('prenume') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row">
                                <label id="label-email" for="telefon" class="col-md-4 col-form-label text-md-right">{{ __('Telefon') }}</label>

                                <div class="col-md-6">
                                    <input id="telefon" type="text" class="form-control{{ $errors->has('telefon') ? ' is-invalid' : '' }}" name="telefon" value="{{ old('telefon') }}" autofocus>

                                    @if ($errors->has('telefon'))
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('telefon') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row">
                                <label id="label-email" for="data_nastere" class="col-md-4 col-form-label text-md-right">{{ __('Data nasterii') }}</label>

                                <div class="col-md-6">
                                    <input id="data_nastere" type="date" min="1950-01-01" max="2002-01-01" class="form-control{{ $errors->has('data_nastere') ? ' is-invalid' : '' }}" name="data_nastere" value="{{ old('data_nastere') }}" required autofocus>

                                    @if ($errors->has('data_nastere'))
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('data_nastere') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row">
                                <label id="label-email" for="email" class="col-md-4 col-form-label text-md-right">{{ __('Adresa Email') }}</label>

                                <div class="col-md-6">
                                    <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required>

                                    @if ($errors->has('email'))
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row">
                                <label id="label-email" for="password" class="col-md-4 col-form-label text-md-right">{{ __('Parola') }}</label>

                                <div class="col-md-6">
                                    <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required>

                                    @if ($errors->has('password'))
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row">
                                <label id="label-email" for="password-confirm" class="col-md-4 col-form-label text-md-right">{{ __('Confirma Parola') }}</label>

                                <div class="col-md-6">
                                    <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label id="label-email" for="image" class="col-md-4 col-form-label text-md-right">{{ __('Selectati un avatar') }}</label>

                                <div class="col-md-6">
                                    <input id="file" type="file" class="form-control{{ $errors->has('imagine') ? ' is-invalid' : '' }}" name="imagine" >

                                    @if ($errors->has('imagine'))
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('imagine') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" id="btn-submit-login" class="btn btn-primary">
                                        {{ __('Inregistrare') }}
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
