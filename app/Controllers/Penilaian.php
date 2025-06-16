<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\PenilaianModel;
use CodeIgniter\HTTP\ResponseInterface;

class Penilaian extends BaseController
{
    public function index()
    {
    
        $model = new PenilaianModel();
        $data = $model->getPenilaian(); // ambil semua data dari tabel mahasiswa

        return $this->response->setJSON($data); // tampilkan dalam bentuk JSON

    }
    public function create()
    {
        $model = new PenilaianModel();

        // Ambil data yang dikirimkan melalui POST
        $data = [
            'id_prodi'      => $this->request->getVar('id_prodi'),
            'id_dosen'      => $this->request->getVar('id_dosen'),
            'sks'           => $this->request->getVar('sks'),
            'aspek_nilai'   => $this->request->getVar('aspek_nilai'),
            'saran'         => $this->request->getVar('saran'),
        ];

        // Validasi input
        if (empty($data['id_prodi']) || empty($data['id_dosen']) || empty($data['sks']) || empty($data['aspek_nilai'])) {
            return $this->response->setJSON([
                'status'  => 400,
                'message' => 'Semua kolom harus diisi'
            ])->setStatusCode(ResponseInterface::HTTP_BAD_REQUEST);
        }

        // Masukkan data ke database
        if ($model->insert($data)) {
            return $this->response->setJSON([
                'status'  => 201,
                'message' => 'Data penilaian berhasil ditambahkan',
                'data'    => $data
            ])->setStatusCode(ResponseInterface::HTTP_CREATED);
        } else {
            return $this->response->setJSON([
                'status'  => 400,
                'message' => 'Gagal menambahkan data penilaian'
            ])->setStatusCode(ResponseInterface::HTTP_BAD_REQUEST);
        }
    }
    public function update($id)
    {
        $model = new PenilaianModel();
        $json = $this->request->getJSON();

        // Siapkan data untuk update
        $data = [
            'id_prodi'      => $json->id_prodi,
            'id_dosen'      => $json->id_dosen,
            'sks'           => $json->sks,
            'aspek_nilai'   => $json->aspek_nilai,
            'saran'         => $json->saran,
        ];

        // Validasi input
        if (empty($data['id_prodi']) || empty($data['id_dosen']) || empty($data['sks']) || empty($data['aspek_nilai'])) {
            return $this->response->setJSON([
                'status'  => 400,
                'message' => 'Semua kolom harus diisi'
            ])->setStatusCode(ResponseInterface::HTTP_BAD_REQUEST);
        }

        // Cek apakah data penilaian ada di database
        $penilaian = $model->find($id);
        if (!$penilaian) {
            return $this->response->setJSON([
                'status'  => 404,
                'message' => 'Penilaian tidak ditemukan'
            ])->setStatusCode(ResponseInterface::HTTP_NOT_FOUND);
        }

        // Update data penilaian
        if ($model->update($id, $data)) {
            return $this->response->setJSON([
                'status'  => 200,
                'message' => 'Data penilaian berhasil diupdate',
                'data'    => $data
            ])->setStatusCode(ResponseInterface::HTTP_OK);
        } else {
            return $this->response->setJSON([
                'status'  => 500,
                'message' => 'Gagal update data penilaian'
            ])->setStatusCode(ResponseInterface::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}

