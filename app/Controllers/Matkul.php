<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\MatkulModel;
use CodeIgniter\HTTP\ResponseInterface;

class Matkul extends BaseController
{
    public function index()
    {
        $model = new MatkulModel();
        $data = $model->getMatkul(); // ambil semua data dari tabel mahasiswa

        return $this->response->setJSON($data); // tampilkan dalam bentuk JSON

    }

    public function create()
    {
        $model = new MatkulModel();

        // Ambil data dari request POST
        $data = [
            'nama_matkul' => $this->request->getVar('nama_matkul'),
            'id_prodi'    => $this->request->getVar('id_prodi'),
            'sks'         => $this->request->getVar('sks'),
        ];

        // Validasi input (misalnya, bisa ditambahkan validasi disini)
        if (empty($data['nama_matkul']) || empty($data['id_prodi']) || empty($data['sks'])) {
            return $this->response->setJSON([
                'status'  => 400,
                'message' => 'Semua kolom harus diisi'
            ])->setStatusCode(ResponseInterface::HTTP_BAD_REQUEST);
        }

        // Simpan data ke database
        if ($model->insert($data)) {
            return $this->response->setJSON([
                'status'  => 201,
                'message' => 'Data mata kuliah berhasil ditambahkan',
                'data'    => $data
            ])->setStatusCode(ResponseInterface::HTTP_CREATED);
        } else {
            return $this->response->setJSON([
                'status'  => 400,
                'message' => 'Gagal menambahkan data'
            ])->setStatusCode(ResponseInterface::HTTP_BAD_REQUEST);
        }
    }

    public function update($id)
{
    $model = new MatkulModel();

    // Ambil data dari request PUT
    $json = $this->request->getJSON();

    // Persiapkan data yang ingin diupdate
    $data = [
        'nama_matkul' => $json->nama_matkul,
        'id_prodi'    => $json->id_prodi,
        'sks'         => $json->sks,
    ];

    // Validasi input (misalnya, bisa ditambahkan validasi disini)
    if (empty($data['nama_matkul']) || empty($data['id_prodi']) || empty($data['sks'])) {
        return $this->response->setJSON([
            'status'  => 400,
            'message' => 'Semua kolom harus diisi'
        ])->setStatusCode(ResponseInterface::HTTP_BAD_REQUEST);
    }

    // Update data di database
    if ($model->update($id, $data)) {
        return $this->response->setJSON([
            'status'  => 200,
            'message' => 'Data mata kuliah berhasil diupdate',
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
    $model = new MatkulModel();

    if ($model->delete($id)) {
        $response = [
            'status' => 200,
            'message' => 'Data Mata Kuliah Berhasil Dihapus'
        ];
        return $this->response->setJSON($response)->setStatusCode(ResponseInterface::HTTP_OK);
    } else {
        $response = [
            'status' => 400,
            'message' => 'Gagal menghapus data'
        ];
        return $this->response->setJSON($response)->setStatusCode(ResponseInterface::HTTP_BAD_REQUEST);
    }
}
public function show($id = null)
{
    $model = new MatkulModel();
    $data = $model->find($id);

    if ($data) {
        // Ambil nama prodi
        $prodiModel = new \App\Models\ProdiModel();
        $prodi = $prodiModel->find($data['id_prodi']);
        $data['nama_prodi'] = $prodi ? $prodi['nama_prodi'] : '';

        return $this->response->setJSON([
            'status' => 200,
            'message' => 'Data mata kuliah ditemukan',
            'data' => $data
        ])->setStatusCode(ResponseInterface::HTTP_OK);
    } else {
        return $this->response->setJSON([
            'status' => 404,
            'message' => 'Data mata kuliah tidak ditemukan'
        ])->setStatusCode(ResponseInterface::HTTP_NOT_FOUND);
    }
}
public function getAll()
{
    $model = new \App\Models\MatkulModel();
    $data = $model->findAll();
    return $this->response->setJSON($data);
}
}
