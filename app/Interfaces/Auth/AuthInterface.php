<?php

namespace App\Interfaces\Auth;

use Illuminate\Http\Request;
use App\Http\Requests\Auth\AuthRequest;

interface AuthInterface
{
    public function getProfile(Request $request);

    public function login(AuthRequest $request);
}
