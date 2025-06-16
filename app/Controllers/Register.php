<?php

namespace App\Controllers;

use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\RESTful\ResourceController;
use App\Models\UserModel;
use CodeIgniter\API\ResponseTrait;
use Symfony\Contracts\Service\Attribute\Required;
use Firebase\JWT\JWT;

class Register extends ResourceController
{
    /**
     * Return an array of resource objects, themselves in array format.
     *
     * @return ResponseInterface
     */
    use ResponseTrait;
    public function index()
{
    helper(['form']);

    // Ambil data dari POST atau JSON
    $data = $this->request->getPost();
    if (empty($data)) {
        $json = $this->request->getJSON(true);
        if (!$json) {
            return $this->fail([
                'status' => 'error',
                'message' => 'Data tidak ditemukan dalam format yang sesuai (POST atau JSON)'
            ]);
        }

        $data = [
            'email' => $json['email'] ?? '',
            'password' => $json['password'] ?? '',
            'confpassword' => $json['confpassword'] ?? ''
        ];
    }

    // Validasi
    $rules = [
        'email' => 'required|valid_email|is_unique[users.email]',
        'password' => 'required|min_length[6]',
        'confpassword' => 'required|matches[password]'
    ];

    if (!$this->validateData($data, $rules)) {
        return $this->fail([
            'status' => 'error',
            'message' => $this->validator->getErrors()
        ]);
    }

    // Simpan user
    $userModel = new UserModel();
    $userData = [
        'email'    => $data['email'],
        'password' => password_hash($data['password'], PASSWORD_BCRYPT)
    ];
    $userModel->save($userData);

    $userId = $userModel->getInsertID();

    $key = getenv('TOKEN_SECRET');
    $payload = [
        'iss' => 'localhost',
        'aud' => 'localhost',
        'iat' => time(),
        'exp' => time() + 3600,
        'uid' => $userId,
        'email' => $data['email']
    ];
    $token = JWT::encode($payload, $key, 'HS256');

    return $this->respondCreated([
        'status' => 'success',
        'message' => 'User berhasil didaftarkan',
        'token' => $token
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
