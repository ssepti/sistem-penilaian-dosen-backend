<?php

namespace App\Controllers;

use App\Models\UserModel;
use CodeIgniter\API\ResponseTrait;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\RESTful\ResourceController;
use Firebase\JWT\JWT;

class Login extends ResourceController
{
    /**
     * Return an array of resource objects, themselves in array format.
     *
     * @return ResponseInterface
     */
    use ResponseTrait;
    public function index()
    {
        //
        helper(['form']);
        $rules = [
            'email' => 'required|valid_email',
            'password' => 'required|min_length[6]',
        ];
        if (!$this->validate($rules)) return $this->fail($this->validator->getErrors());
        $model = new UserModel();
        $user = $model->where('email', $this->request->getVar('email'))->first();
        if(!$user) return $this->failNotFound('Email Not Found');

        $verify = password_verify($this->request->getVar('password'), $user['password']);
        if(!$verify) return $this->fail('Wrong Password');

        $key = getenv('TOKEN_SECRET');
        // Tentukan role berdasarkan domain email
$role = 'guest'; // default

if (strpos($user['email'], '@stu.ac.id') !== false) {
    $role = 'mahasiswa';
} elseif (strpos($user['email'], '@dosen.ac.id') !== false) {
    $role = 'dosen';
} elseif (strpos($user['email'], '@admin.ac.id') !== false) {
    $role = 'admin';
}

$payload = array(
    "iat" => time(),
    "nbf" => time(),
    "uid" => $user['id'],
    "email" => $user['email'],
    "role" => $role
);


        $token = JWT::encode($payload, $key, 'HS256');


        return $this->respond([
    'token' => $token,
    'role'  => $role
]);


    }

    /**
     * Return the properties of a resource object.
     *
     * @param int|string|null $id
     *
     * @return ResponseInterface
     */
    public function show($id = null)
    {
        //
    }

    /**
     * Return a new resource object, with default properties.
     *
     * @return ResponseInterface
     */
    public function new()
    {
        //
    }

    /**
     * Create a new resource object, from "posted" parameters.
     *
     * @return ResponseInterface
     */
    public function create()
    {
        //
    }

    /**
     * Return the editable properties of a resource object.
     *
     * @param int|string|null $id
     *
     * @return ResponseInterface
     */
    public function edit($id = null)
    {
        //
    }

    /**
     * Add or update a model resource, from "posted" properties.
     *
     * @param int|string|null $id
     *
     * @return ResponseInterface
     */
    public function update($id = null)
    {
        //
    }

    /**
     * Delete the designated resource object from the model.
     *
     * @param int|string|null $id
     *
     * @return ResponseInterface
     */
    public function delete($id = null)
    {
        //
    }
}
