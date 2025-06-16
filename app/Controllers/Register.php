<?php

namespace App\Controllers;

use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\RESTful\ResourceController;
use App\Models\UserModel;
use CodeIgniter\API\ResponseTrait;
use Firebase\JWT\JWT;

class Register extends ResourceController
{
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
                'email'        => $json['email'] ?? '',
                'password'     => $json['password'] ?? '',
                'confpassword' => $json['confpassword'] ?? ''
            ];
        }

        // Validasi
        $rules = [
            'email'        => 'required|valid_email|is_unique[users.email]',
            'password'     => 'required|min_length[6]',
            'confpassword' => 'required|matches[password]'
        ];

        if (!$this->validateData($data, $rules)) {
            return $this->fail([
                'status' => 'error',
                'message' => $this->validator->getErrors()
            ]);
        }

        // 🔐 Tentukan role berdasarkan domain email
        if (strpos($data['email'], '@stu.ac.id') !== false) {
            $role = 'mahasiswa';
        } elseif (strpos($data['email'], '@dosen.ac.id') !== false) {
            $role = 'dosen';
        } else {
            $role = 'admin';
        }

        // Simpan ke database
        $userModel = new UserModel();
        $userData = [
            'email'    => $data['email'],
            'password' => password_hash($data['password'], PASSWORD_BCRYPT),
            'role'     => $role // simpan role ke DB
        ];
        $userModel->save($userData);

        $userId = $userModel->getInsertID();

        // 🔑 Buat token JWT
        $key = getenv('TOKEN_SECRET');
        $payload = [
            'iss'   => 'localhost',
            'aud'   => 'localhost',
            'iat'   => time(),
            'exp'   => time() + (30 * 24 * 3600),
            'uid'   => $userId,
            'email' => $data['email'],
            'role'  => $role // role juga masuk token
        ];
        $token = JWT::encode($payload, $key, 'HS256');

        return $this->respondCreated([
            'status'  => 'success',
            'message' => 'User berhasil didaftarkan',
            'role'    => $role,
            'token'   => $token
        ]);
    }
}
