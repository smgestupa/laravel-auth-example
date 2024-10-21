<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class AuthController extends Controller
{   
    function getLogin() {
        return view("login");
    }

    function getRegister() {
        return view("register");
    }
    
    function postLogin(Request $request) {
        $request->validate([
            "email" => "required|email",
            "password" => "required"
        ]);

        $credentials = $request->only("email", "password");
        
        if (Auth::attempt($credentials)) {
            return redirect()->intended(route("view.dashboard"))
                ->with("success", "You have successfully logged in");
        }

        return redirect(route("view.login"))
            ->with("error", "Login was unsuccessful, please try again");
    }

    function postRegister(Request $request) {
        $request->validate([
            "name" => "required",
            "email" => "required|unique:users,email|email",
            "password" => "required"
        ]);

        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);

        if ($user->save()) {
            return redirect(route("view.login"))
                ->with("success", "User successfully created");
        }

        return redirect(route("view.register"))
            ->with("error", "Failed to create user, please try again");
    }
}
