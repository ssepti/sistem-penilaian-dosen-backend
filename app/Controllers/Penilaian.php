<?php

namespace App\Controllers;

use App\Models\PenilaianModel;
use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\HTTP\ResponseInterface;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class Penilaian extends ResourceController
{
    public function index()
    {
        $model = new PenilaianModel();
        $data = $model->getPenilaian(); // custom method jika kamu pakai join
        return $this->respond($data);
    }

    public function create()
    {
        $role = $this->getUserRole();
        if ($role !== 'mahasiswa') {
            return $this->failForbidden('Hanya mahasiswa yang bisa menambahkan penilaian');
        }

        $data = $this->request->getJSON(true); // ambil input sebagai array

        if (
            empty($data['id_prodi']) ||
            empty($data['id_dosen']) ||
            empty($data['sks']) ||
            empty($data['aspek_nilai'])
        ) {
            return $this->fail('Semua kolom harus diisi');
        }

        $model = new PenilaianModel();
        if ($model->insert($data)) {
            return $this->respondCreated([
                'message' => 'Data penilaian berhasil ditambahkan',
                'data' => $data
            ]);
        } else {
            return $this->fail('Gagal menambahkan data penilaian');
        }
    }

    public function update($id = null)
    {
        $role = $this->getUserRole();
        if ($role !== 'mahasiswa') {
            return $this->failForbidden('Hanya mahasiswa yang bisa mengubah penilaian');
        }

        $data = $this->request->getJSON(true); // ambil sebagai array

        if (
            empty($data['id_prodi']) ||
            empty($data['id_dosen']) ||
            empty($data['sks']) ||
            empty($data['aspek_nilai'])
        ) {
            return $this->fail('Semua kolom harus diisi');
        }

        $model = new PenilaianModel();
        if (!$model->find($id)) {
            return $this->failNotFound('Penilaian tidak ditemukan');
        }

        if ($model->update($id, $data)) {
            return $this->respond([
                'message' => 'Data penilaian berhasil diupdate',
                'data' => $data
            ]);
        } else {
            return $this->fail('Gagal mengupdate data');
        }
    }

    public function delete($id = null)
    {
        $model = new PenilaianModel();
        if (!$model->find($id)) {
            return $this->failNotFound('Data penilaian tidak ditemukan');
        }

        if ($model->delete($id)) {
            return $this->respondDeleted([
                'message' => 'Data penilaian berhasil dihapus'
            ]);
        } else {
            return $this->fail('Gagal menghapus data');
        }
    }

    public function show($id = null)
    {
        $model = new PenilaianModel();
        $data = $model->find($id);
        if ($data) {
            return $this->respond($data);
        } else {
            return $this->failNotFound('Data penilaian tidak ditemukan');
        }
    }

    public function getAll()
    {
        $model = new PenilaianModel();
        $data = $model->findAll();
        return $this->respond($data);
    }

    private function getUserRole()
    {
        $authHeader = $this->request->getHeader("Authorization");
        if (!$authHeader) return null;

        try {
            $token = explode(' ', $authHeader->getValue())[1]; // Bearer <token>
            $key = getenv('TOKEN_SECRET');
            $decoded = JWT::decode($token, new Key($key, 'HS256'));

            // Deteksi role berdasarkan email
            if (isset($decoded->email) && strpos($decoded->email, '@stu.ac.id') !== false) {
                return 'mahasiswa';
            }

            return 'admin'; // fallback
        } catch (\Exception $e) {
            return null;
        }
    }
}
