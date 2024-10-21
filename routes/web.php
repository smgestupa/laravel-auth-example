<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    return view('index');
});

Route::get("/login", [AuthController::class, "getLogin"])
    ->name("view.login");
Route::post("/login", [AuthController::class, "postLogin"])
    ->name("auth.login");

Route::get("/register", [AuthController::class, "getRegister"])
    ->name("view.register");
Route::post("/register", [AuthController::class, "postRegister"])
    ->name("auth.register");


Route::get("/dashboard", function () {
    return view("dashboard");
})
    ->name("view.dashboard")
    ->middleware("auth");

Route::get("/logout", function () {
    Auth::logout();
    return redirect("login")->with("success", "You have successfully logged out");
})->name("auth.logout");