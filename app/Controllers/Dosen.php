<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\DosenModel;
use CodeIgniter\HTTP\ResponseInterface;

class Dosen extends BaseController
{
    public function index()
    {
        $model = new DosenModel();
        $data = $model->getDosen(); // ambil semua data dari tabel dosen

        return $this->response->setJSON($data); // tampilkan dalam bentuk JSON

    }
    
    public function create()
    {
        $model = new \App\Models\DosenModel();
        $json = $this->request->getJSON();
    
        $data = [
            'nama_dosen' => $json->nama_dosen,
            'nidn' => $json->nidn,
            'id_prodi' => $json->id_prodi,
            'id_matkul' => $json->id_matkul,
        ];
    
        // Insert data dosen
        if ($model->insert($data)) {
            // Mendapatkan nama prodi berdasarkan id_prodi
            $prodiModel = new \App\Models\ProdiModel();
            $prodi = $prodiModel->find($data['id_prodi']);
    
            // Mendapatkan nama matkul berdasarkan id_matkul
            $matkulModel = new \App\Models\MatkulModel();
            $matkul = $matkulModel->find($data['id_matkul']);
    
            // Menambahkan nama_prodi dan nama_matkul ke data dosen
            $data['nama_prodi'] = $prodi ? $prodi['nama_prodi'] : '';
            $data['nama_matkul'] = $matkul ? $matkul['nama_matkul'] : '';
    
            // Hapus id_prodi dan id_matkul dari response
            unset($data['id_prodi'], $data['id_matkul']);
    
            return $this->response->setJSON([
                'status' => 201,
                'message' => 'Data dosen berhasil ditambahkan',
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
        $model = new DosenModel();

        // Ambil data dari request PUT
        $json = $this->request->getJSON();

        // Persiapkan data yang ingin diupdate
        $data = [
            'nama_dosen'   => $json->nama_dosen,
            'nidn'         => $json->nidn,
            'id_prodi'     => $json->id_prodi,
            'id_matkul'    => $json->id_matkul,
        ];

        // Validasi input (misalnya, bisa ditambahkan validasi disini)
        if (empty($data['nama_dosen']) || empty($data['nidn']) || empty($data['id_prodi']) || empty($data['id_matkul'])) {
            return $this->response->setJSON([
                'status'  => 400,
                'message' => 'Semua kolom harus diisi'
            ])->setStatusCode(ResponseInterface::HTTP_BAD_REQUEST);
        }

        // Update data di database
        if ($model->update($id, $data)) {
            return $this->response->setJSON([
                'status'  => 200,
                'message' => 'Data dosen berhasil diupdate',
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
    $model = new DosenModel();

    if ($model->delete($id)) {
        $response = [
            'status' => 200,
            'message' => 'Data Dosen Berhasil Dihapus'
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
