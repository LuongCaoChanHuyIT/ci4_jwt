<?php
/**
 * @var \CodeIgniter\HTTP\IncomingRequest $request
 */
namespace App\Controllers;

use App\Libraries\JWTLib;
use CodeIgniter\RESTful\ResourceController;
use App\Models\User;

class UserController extends ResourceController
{

    protected $request;
    protected $userModel;
    protected $jwt;

    public function __construct()
    {
        $this->userModel = new User();
        $this->jwt = new JWTLib();
    }

    public function create()
    {
        $this->userModel->save([
            'username' => 'admin',
            'email'    => 'admin@example.com',
            'password' => password_hash('123456', PASSWORD_DEFAULT),
        ]);

        return $this->respond(['message' => 'User created']);
    }

    public function login()
    {
        $json = $this->request->getJSON(true);

        $user = $this->userModel->where('email', $json['email'])->first();

        if (!$user || !password_verify($json['password'], $user['password'])) {
            return $this->respond(['message' => 'Invalid credentials']);
        }

        $token = $this->jwt->createToken([
            'id' => $user['id'],
            'email' => $user['email']
        ]);

        return $this->respond(['token' => $token]);
    }

    public function profile()
    {
        $user = $this->request->user;

        return $this->respond([
            'status' => true,
            'data'   => $user
        ]);
    }
}
