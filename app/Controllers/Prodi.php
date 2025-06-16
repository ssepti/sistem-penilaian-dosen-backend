<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ProdiModel;
use CodeIgniter\HTTP\ResponseInterface;

class Prodi extends BaseController
{
    // TAMPILKAN SEMUA PRODI
    public function index()
    {
        $model = new ProdiModel();
        $data = $model->findAll();

        return $this->response->setJSON($data);
    }

    // TAMBAH DATA PRODI
    public function create()
    {
        $model = new ProdiModel();

        $data = [
            'nama_prodi' => $this->request->getVar('nama_prodi'),
        ];

        if ($model->insert($data)) {
            return $this->response->setJSON([
                'status' => 201,
                'message' => 'Data prodi berhasil ditambahkan',
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
    $model = new \App\Models\ProdiModel();
    $json = $this->request->getJSON();

    $data = [
        'nama_prodi' => $json->nama_prodi
    ];

    if ($model->update($id, $data)) {
        return $this->response->setJSON([
            'status' => 200,
            'message' => 'Data prodi berhasil diupdate',
            'data' => $data
        ]);
    } else {
        return $this->response->setJSON([
            'status' => 400,
            'message' => 'Gagal update data'
        ]);
    }

}
public function delete($id = null)
{
    $model = new ProdiModel();

    if ($model->delete($id)) {
        $response = [
            'status' => 200,
            'message' => 'Data Prodi Berhasil Dihapus'
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



}


