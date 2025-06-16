<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\AdminModel;
use CodeIgniter\HTTP\ResponseInterface;

class Admin extends BaseController
{
  
        public function index()
    {
        $model = new AdminModel();
        $data = $model->findAll(); // ambil semua data dari tabel mahasiswa

        return $this->response->setJSON($data); // tampilkan dalam bentuk JSON

    }
    public function update($id)
    {
        $model = new AdminModel();

        // Ambil data dari request PUT
        $json = $this->request->getJSON();

        // Persiapkan data yang ingin diupdate
        $data = [
            'username' => $json->username,
            'password' => password_hash($json->password, PASSWORD_BCRYPT), // Hash password sebelum disimpan
        ];

        // Validasi input
        if (empty($data['username']) || empty($data['password'])) {
            return $this->response->setJSON([
                'status'  => 400,
                'message' => 'Username dan password harus diisi'
            ])->setStatusCode(ResponseInterface::HTTP_BAD_REQUEST);
        }

        // Update data di database
        if ($model->update($id, $data)) {
            return $this->response->setJSON([
                'status'  => 200,
                'message' => 'Data admin berhasil diupdate',
                'data'    => $data
            ])->setStatusCode(ResponseInterface::HTTP_OK);
        } else {
            return $this->response->setJSON([
                'status'  => 400,
                'message' => 'Gagal mengupdate data'
            ])->setStatusCode(ResponseInterface::HTTP_BAD_REQUEST);
        }
    }
    }
