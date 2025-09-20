<?php

namespace App\Filters;

use App\Libraries\JWTLib;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;
use Config\Services;

class AuthFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        $authHeader = $request->getHeaderLine('Authorization');
        if (!$authHeader) {
            return Services::response()
                ->setJSON(['status' => false, 'message' => 'Token required'])
                ->setStatusCode(401);
        }

        $token = null;
        if (preg_match('/Bearer\s(\S+)/', $authHeader, $matches)) {
            $token = $matches[1];
        }

        $jwtLib = new JWTLib();
        $decoded = $jwtLib->decodeToken($token);

        if (!$decoded) {
            return Services::response()
                ->setJSON(['status' => false, 'message' => 'Invalid or expired token'])
                ->setStatusCode(401);
        }

        // Bạn có thể gán thông tin user vào request để dùng sau
        $request->user = $decoded->data;
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
    }
}
