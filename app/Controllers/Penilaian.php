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

        return $this->response->setJSON($data); // tampilkan dalam bentuk JSON

    }
    public function create()
{
    $user = $this->getUser();
    $model = new PenilaianModel();

    $data = [
        'id_mahasiswa'  => $user->id_mahasiswa,
        'id_prodi'      => $this->request->getVar('id_prodi'),
        'id_dosen'      => $this->request->getVar('id_dosen'),
        'id_matkul'      => $this->request->getVar('id_matkul'),
        'sks'           => $this->request->getVar('sks'),
        'aspek_nilai'   => $this->request->getVar('aspek_nilai'),
        'saran'         => $this->request->getVar('saran'),
        'status'        => 'Belum Diisi'
    ];

    $cek = $model->where('id_mahasiswa', $user->id_mahasiswa)
             ->where('id_dosen', $this->request->getVar('id_dosen'))
             ->first();

        if ($cek) {
    return $this->response->setJSON([
        'status' => 409,
        'message' => 'Penilaian untuk dosen ini sudah pernah diisi'
    ])->setStatusCode(409);
    }

    // Validasi
    if (empty($data['id_prodi']) || empty($data['id_dosen']) || empty($data['id_matkul']) || empty($data['sks']) || empty($data['aspek_nilai'])) {
        return $this->response->setJSON([
            'status'  => 400,
            'message' => 'Semua kolom wajib diisi'
        ])->setStatusCode(ResponseInterface::HTTP_BAD_REQUEST);
    }

    if ($model->insert($data)) {
        return $this->response->setJSON([
            'status'  => 201,
            'message' => 'Penilaian berhasil ditambahkan',
            'data'    => $data
        ])->setStatusCode(ResponseInterface::HTTP_CREATED);
    } else {
        return $this->response->setJSON([
            'status'  => 400,
            'message' => 'Gagal menambahkan penilaian'
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
        'id_matkul'      => $json->id_matkul,
        'sks'           => $json->sks,
        'aspek_nilai'   => $json->aspek_nilai,
        'saran'         => $json->saran,
        'status'        => 'Sudah Diisi' // status diubah saat update
    ];

    // Validasi input
    if (empty($data['id_prodi']) || empty($data['id_dosen']) || empty($data['sks']) || empty($data['aspek_nilai'])) {
        return $this->response->setJSON([
            'status'  => 400,
            'message' => 'Semua kolom harus diisi'
        ])->setStatusCode(ResponseInterface::HTTP_BAD_REQUEST);
    }

    // Cek apakah data penilaian ada
    $penilaian = $model->find($id);
    if (!$penilaian) {
        return $this->response->setJSON([
            'status'  => 404,
            'message' => 'Penilaian tidak ditemukan'
        ])->setStatusCode(ResponseInterface::HTTP_NOT_FOUND);
    }

    // Update data
    if ($model->update($id, $data)) {
        return $this->response->setJSON([
            'status'  => 200,
            'message' => 'Penilaian berhasil diperbarui',
            'data'    => $data
        ])->setStatusCode(ResponseInterface::HTTP_OK);
    } else {
        return $this->response->setJSON([
            'status'  => 500,
            'message' => 'Gagal memperbarui data penilaian'
        ])->setStatusCode(ResponseInterface::HTTP_INTERNAL_SERVER_ERROR);
    }
}


    public function delete($id = null)
{
    $model = new \App\Models\PenilaianModel();

    // Cek apakah data penilaian dengan ID tersebut ada
    $penilaian = $model->find($id);
    if (!$penilaian) {
        return $this->response->setJSON([
            'status'  => 404,
            'message' => 'Data penilaian tidak ditemukan'
        ])->setStatusCode(ResponseInterface::HTTP_NOT_FOUND);
    }

    // Hapus data
    if ($model->delete($id)) {
        return $this->response->setJSON([
            'status'  => 200,
            'message' => 'Data penilaian berhasil dihapus'
        ])->setStatusCode(ResponseInterface::HTTP_OK);
    } else {
        return $this->response->setJSON([
            'status'  => 400,
            'message' => 'Gagal menghapus data penilaian'
        ])->setStatusCode(ResponseInterface::HTTP_BAD_REQUEST);
    }
}

    public function show($id = null)
{
    $model = new PenilaianModel();
    $data = $model->find($id);

    if ($data) {
        return $this->response->setJSON([
            'status' => 200,
            'message' => 'Data penilaian ditemukan',
            'data' => $data
        ])->setStatusCode(ResponseInterface::HTTP_OK);
    } else {
        return $this->response->setJSON([
            'status' => 404,
            'message' => 'Data penilaian tidak ditemukan'
        ])->setStatusCode(ResponseInterface::HTTP_NOT_FOUND);
    }
}
public function getAll()
{
    $model = new \App\Models\PenilaianModel();
    $data = $model->findAll();
    return $this->response->setJSON($data);
}

private function getUser()
{
    $authHeader = $this->request->getHeader("Authorization");
    if (!$authHeader) return null;

    $token = explode(' ', $authHeader->getValue())[1]; // Bearer xxx
    $key = getenv('TOKEN_SECRET');

    try {
        $decoded = \Firebase\JWT\JWT::decode($token, new \Firebase\JWT\Key($key, 'HS256'));
        return $decoded;
    } catch (\Exception $e) {
        return null;
    }
}

public function penilaianBelumDiisi()
{
    $model = new PenilaianModel();
    $data = $model->where('status', 'Belum Diisi')->findAll();

    return $this->response->setJSON($data);
}

public function riwayatPenilaian()
{
    $model = new PenilaianModel();
    $data = $model->where('status', 'Sudah Diisi')->findAll();

    return $this->response->setJSON($data);
}
public function getDosenByProdi()
{
    $user = $this->getUser(); // dari token JWT
    $idProdi = $user->id_prodi;

    $dosenModel = new \App\Models\DosenModel();
    $data = $dosenModel->where('id_prodi', $idProdi)->findAll();

    return $this->response->setJSON($data);
}



}