<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;

class UserContoller extends Controller
{
    public function index()
    {
        $users=User::with('role')->get();
        return view('users.index',compact('users'));
    }

    public function create()
    {
        return view('users.create');
    }

    public function store(StoreUserRequest $request)
    {
        $user= new User();
        $user->name=$request['name'];
        $user->email=$request['email'];
        $user->password=$request['password'];
        $user->role=$request['role'];
        $user->save();

        return redirect()->route('users.index')->with('success', 'User ajouté avec succès !');
    }


    public function show(int $id)
    {
        $user=User::findOrFail($id);
        return view('users.show',compact('user'));
    }

    public function edit(int $id)
    {
        $user=User::findOrFail($id);
        return view('users.edit',compact('user'));
    }


    public function update(UpdateUserRequest $request, int $id)
    {
        $user=User::findOrFail($id);
        $user->name=$request['name'];
        $user->email=$request['email'];
        if($request->has('password') && $request->password != ""){
            $user->password=Hash::make($request['password']);
        }
        $user->role=$request['role'];
        $user->save();

         return redirect()->route('users.index')->with('success', 'User mis à jour avec succès !');

    }


    public function destroy(int $id)
    {
        $user=User::findOrFail($id);
        $user->delete();
        return redirect()->route('users.index')->with('success', 'User supprimé avec succès !');
    }

    public function editProfile()
    {
        return view('profile.edit', [
            'user' => auth()->user(),
        ]);
    }

    public function updateProfile(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,'.auth()->id()],
        ]);
        
        $user = auth()->user();
        $user->fill($request->only('name', 'email'));
        $user->save();

        return redirect()->route('profile.edit')->with('status', 'profile-updated');
    }
}
