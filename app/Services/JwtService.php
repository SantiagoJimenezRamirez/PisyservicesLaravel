<?php

namespace App\Services;

use Firebase\JWT\JWT;

class JwtService
{
    private $secretKey = 'your_secret_key'; // Define your secret key for JWT

    public function generateToken($data)
    {
        $issuedAt = time();
        $expirationTime = $issuedAt + 3600;  // jwt valid for 1 hour from the issued time
        $payload = [
            'iat' => $issuedAt,
            'exp' => $expirationTime,
            'data' => $data,
        ];

        return JWT::encode($payload, $this->secretKey, 'HS256');

    }
}
