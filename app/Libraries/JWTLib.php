<?php

namespace App\Libraries;

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class JWTLib
{
    protected $key;
    protected $ttl;

    public function __construct()
    {
        $this->key = getenv('JWT_SECRET');
        $this->ttl = getenv('JWT_TIME_TO_LIVE');
    }

    public function createToken($userData)
    {
        $issuedAt   = time();
        $expire     = $issuedAt + $this->ttl;

        $payload = [
            'iat'  => $issuedAt,         // issued at
            'exp'  => $expire,           // expiration time
            'data' => $userData,         // user data (id, email, etc.)
        ];

        return JWT::encode($payload, $this->key, 'HS256');
    }

    public function decodeToken($jwt)
    {
        try {
            return JWT::decode($jwt, new Key($this->key, 'HS256'));
        } catch (\Exception $e) {
            return null;
        }
    }
}
