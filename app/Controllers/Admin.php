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
    public function create()
{
    $model = new \App\Models\AdminModel();
    $json = $this->request->getJSON();

    // Validasi input awal
    if (!isset($json->username) || !isset($json->password)) {
        return $this->response->setJSON([
            'status'  => 400,
            'message' => 'Username dan password harus diisi'
        ])->setStatusCode(ResponseInterface::HTTP_BAD_REQUEST);
    }

    // Data yang akan disimpan
    $data = [
        'username' => $json->username,
        'password' => password_hash($json->password, PASSWORD_BCRYPT),
    ];

    if ($model->insert($data)) {
        // Jangan tampilkan password hash dalam response (opsional)
        $data['password'] = '[protected]';

        return $this->response->setJSON([
            'status' => 201,
            'message' => 'Data admin berhasil ditambahkan',
            'data' => $data
        ])->setStatusCode(ResponseInterface::HTTP_CREATED);
    } else {
        return $this->response->setJSON([
            'status' => 400,
            'message' => 'Gagal menambahkan data'
        ])->setStatusCode(ResponseInterface::HTTP_BAD_REQUEST);
    }
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

public function delete($id = null)
{
    $model = new \App\Models\AdminModel();

    // Cek apakah data admin dengan ID tersebut ada
    $admin = $model->find($id);
    if (!$admin) {
        return $this->response->setJSON([
            'status'  => 404,
            'message' => 'Data admin tidak ditemukan'
        ])->setStatusCode(ResponseInterface::HTTP_NOT_FOUND);
    }

    // Hapus data
    if ($model->delete($id)) {
        return $this->response->setJSON([
            'status'  => 200,
            'message' => 'Data admin berhasil dihapus'
        ])->setStatusCode(ResponseInterface::HTTP_OK);
    } else {
        return $this->response->setJSON([
            'status'  => 400,
            'message' => 'Gagal menghapus data admin'
        ])->setStatusCode(ResponseInterface::HTTP_BAD_REQUEST);
    }
}


    public function show($id = null)
    {
        $model = new AdminModel();
        $data = $model->find($id);

        if ($data) {
            return $this->response->setJSON([
                'status' => 200,
                'message' => 'Data admin ditemukan',
                'data' => $data
            ])->setStatusCode(ResponseInterface::HTTP_OK);
        } else {
            return $this->response->setJSON([
                'status' => 404,
                'message' => 'Data admin tidak ditemukan'
            ])->setStatusCode(ResponseInterface::HTTP_NOT_FOUND);
        }
    }
    public function getAll()
{
    $model = new \App\Models\AdminModel();
    $data = $model->findAll();
    return $this->response->setJSON($data);
}
    }
