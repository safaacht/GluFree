<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\View;

class LoginController extends Controller
{
    public function create(){
        return view('auth.login');
    }
    public function store(LoginRequest $request){
        $check= Auth::attempt([
        
            'email'=>$request->email,
            'password'=>$request->password
        ]);

        
        
        if($check){
                $request->session()->regenerate();
                if(Auth::user()->role=="admin"){
                    return redirect()->route('admin.dashboard');
                }else{
                    return redirect()->route('client');
                }
            }else{
            return redirect()->back()->with("error","Email or password is incorrect");

        }
    }

    public function destroy(){
         Auth::logout();

        request()->session()->invalidate();
        request()->session()->regenerateToken();

        return redirect()->route('login.create');
    }
}
