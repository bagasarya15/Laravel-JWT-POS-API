<?php

namespace App\Repositories\Auth;

use Carbon\Carbon;
use App\Models\User;
use Illuminate\Http\Request;
use App\Traits\ResponseTrait;
use App\Traits\TokenAccessTrait;
use Illuminate\Support\Facades\DB;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Interfaces\Auth\AuthInterface;
use App\Http\Requests\Auth\AuthRequest;

class AuthRepository implements AuthInterface
{
    use ResponseTrait, TokenAccessTrait;

    private function handleLogLogin($userId, $status){
        DB::table('login_logs')->insert([
            'user_id' => $userId,
            'status' => $status,
            'created_at' => now(),
        ]);
    }

    public function getProfile($request){
        try {
            $auth = auth()->user();

            return response()->json([
                'status' => 200,
                'message' => 'success',
                'records' => $auth
            ]);
        } catch (\Throwable $th) {
            return $th;
        }
    }

    public function login(AuthRequest $request){
        try {
            $credentials = $request->only('username', 'password');
            $user = User::where('username', '=', $request->username)->first();

            if (!$token = JWTAuth::attempt($credentials)) {
                $this->handleLogLogin($user->id, 'Failed');
                return response()->json([
                    'status' => 401,
                    'message' => 'Username atau Password Anda salah'
                ], 401);
            }

            $token = JWTAuth::factory()
            ->setTTL(180)
            ->customClaims([
                'id' => $user->id,
                'username' => $user->username,
            ])->make();

            $token = JWTAuth::fromUser($user);
            $payload = JWTAuth::setToken($token)->getPayload();
            $expirationTime = Carbon::createFromTimestamp($payload->get('exp'))->setTimezone('Asia/Jakarta');

            if($token){
                $this->storeTokenAccess($user->id, $token, $expirationTime);
                $this->handleLogLogin($user->id, 'Success');
            }

            return response()->json([
                'status' => 200,
                'message' => 'Login success',
                'token' => $token
            ], 200);

        } catch (\Throwable $th) {
            return $th;
        }
    }
}
