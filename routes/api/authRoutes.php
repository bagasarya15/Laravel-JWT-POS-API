<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;

Route::prefix("auth")
    ->group(function () {
        Route::post("/login", [AuthController::class, "login"])->name('login');
    });

Route::prefix("auth")->middleware(['auth:api'])->group(function(){
    Route::get("/get-profile", [AuthController::class, "getProfile"]);
});
