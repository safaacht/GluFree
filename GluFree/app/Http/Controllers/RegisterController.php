<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Request as FacadesRequest;

class RegisterController extends Controller
{
    public function create(){
        $cities = \App\Models\City::all();
        return view('auth.register', compact('cities'));
    }

    public function store(RegisterRequest $request){
        $user=User::create([
            'name'=>$request->name,
            'email'=>$request->email,
            'password'=>Hash::make($request->password),
            'role'=>$request->role,
            'tel'=>$request->tel,
            'cin'=>$request->role === 'fournisseur' ? $request->cin : null,
            'ice'=>$request->role === 'fournisseur' ? $request->ice : null,
            'city_id'=>$request->role === 'fournisseur' ? $request->city_id : null,
            'status'=>$request->role === 'fournisseur' ? 'en attente' : null,
        ]);

        Auth::login($user);
        if($user->role === 'fournisseur' && $user->status === 'accepté'){
            return redirect()->route('fournisseur.index');
        }
        return redirect()->route('product.index');
    }
}
