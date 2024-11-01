<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Master\RoleController;
use App\Http\Controllers\Master\UserController;
use App\Http\Controllers\Master\EmployeeController;

Route::prefix("master")
->middleware(['auth:api'])
    ->group(function () {
        Route::apiResource("users", UserController::class)->except(["show"]);
        Route::apiResource("employee", EmployeeController::class)->except(["show"]);
        Route::apiResource("role", RoleController::class)->except(["show"]);
    });
