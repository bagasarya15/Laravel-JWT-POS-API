<?php

namespace App\Traits;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

trait TokenAccessTrait
{
    public function storeTokenAccess($userId, $token, $expiredToken)
    {
        $hasToken = DB::table('token_access')->where('user_id', '=', $userId)->first();

        if ($hasToken) {
            DB::table('token_access')
                ->where('user_id', '=', $userId)->orderBy('created_at', 'ASC')
                ->delete();
        }

        DB::table('token_access')->insert([
            'user_id' => $userId,
            'token' => $token,
            'expired_token' => $expiredToken,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
