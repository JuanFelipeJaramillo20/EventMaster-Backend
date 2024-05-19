<?php

namespace App\Traits;

use Firebase\JWT\JWT;

trait AccessTokenGeneratorTrait
{
    protected function generateAccessToken($user): string
    {

        $payload = [
            'user_id' => $user->getId(),
            'exp' => time() + (30 * 60)
        ];

        $jwtSecret = 'secret_key_test';
        return JWT::encode($payload, $jwtSecret, 'HS256');
    }
}