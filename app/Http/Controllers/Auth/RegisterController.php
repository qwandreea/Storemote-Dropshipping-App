<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Intervention\Image\Facades\Image;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'nume' => 'required|string|max:30|regex:/^[a-zA-Z0]+$/',
            'prenume' => 'required|string|max:30|regex:/^[a-zA-Z]+$/u',
            'telefon' => 'regex:/(0)[0-9]{9}/|max:10|min:10',
            'data_nastere' => 'required',
            'email' => 'required|string|email|max:255|unique:utilizatori',
            'password' => 'required|string|min:6|confirmed',
            'imagine' => 'image|mimes:jpeg,png,jpg|max:2048',
        ],[
            'required' => 'Campul :attribute trebuie completat.',
            'nume.regex' => 'Numele poate conține doar litere, fără spații și diacritice',
            'prenume.regex' => 'Prenumele poate conține doar litere, fără spații și diacritice',
            'telefon.regex' => 'Numarul de telefon e invalid.',
            'telefon.numeric' => 'Campul :attribute trebuie sa contina doar numere.',
            'telefon.max' => 'Campul :attribute trebuie sa contina 10 cifre',
            'max' => 'Campul :attribute trebuie sa contina maxim 30 de caractere.',
            'email' => 'Campul :attribute nu respecta formatul standard.',
            'unique' => 'Adresa de email exista deja.',
            'password.min' => 'Parola trebuie sa contina mimim 6 caractere.',
            'confirmed'=> 'Cele doua parole nu corespund.',
            'imagine.mimes' => 'Avatarul accepta doar extensii jpeg,jpg,png',
            'image' => 'Fisierul trebuie sa fie o imagine.'
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        $user= User::create([
            'calitate' =>$data['calitate'],
            'nume' => $data['nume'],
            'prenume' => $data['prenume'],
            'telefon' => $data['telefon'],
            'data_nastere' => $data['data_nastere'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);

        if(request()->hasFile('imagine')){
            $imagine=request()->file('imagine');
            $numefisier=time() . '.' .$imagine->getClientOriginalExtension();
            Image::make($imagine)->resize(300,300)->save(public_path('uploads/avatar/' .  $numefisier));
            $user->imagine=$numefisier;
            $user->save();
        }
        return $user;
    }
}
