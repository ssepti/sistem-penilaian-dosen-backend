<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\MahasiswaModel;
use CodeIgniter\API\ResponseTrait;
use CodeIgniter\HTTP\ResponseInterface;

class Mahasiswa extends BaseController
{
    use ResponseTrait;

    // TAMPIL DATA
    public function index()
    {
        $model = new MahasiswaModel();
        $data = $model->getMahasiswa(); // tampilkan data dengan nama prodi

        return $this->respond($data, 200); // respon JSON
    }

    // CREATE / TAMBAH DATA
    public function create()
    {
        $model = new \App\Models\MahasiswaModel();
        $json = $this->request->getJSON();
    
        $data = [
            'npm' => $json->npm,
            'password' => $json->password,
            'nama_mhs' => $json->nama_mhs,
            'kelas' => $json->kelas,
            'id_prodi' => $json->id_prodi,
        ];
    
        // Insert data mahasiswa
        if ($model->insert($data)) {
            // Mendapatkan nama prodi setelah data berhasil disimpan
            $prodiModel = new \App\Models\ProdiModel();
            $prodi = $prodiModel->find($data['id_prodi']);
    
            // Menambahkan nama_prodi ke data mahasiswa
            $data['nama_prodi'] = $prodi ? $prodi['nama_prodi'] : '';
    
            // Hapus id_prodi dari response
            unset($data['id_prodi']);
    
            return $this->response->setJSON([
                'status' => 201,
                'message' => 'Data mahasiswa berhasil ditambahkan',
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
    $model = new \App\Models\MahasiswaModel();  // Menggunakan model Mahasiswa
    $json = $this->request->getJSON();

    // Data yang ingin diupdate
    $data = [
        'nama_mhs' => $json->nama_mhs,
        'password' => password_hash($json->password, PASSWORD_DEFAULT),  // Meng-hash password
        'kelas' => $json->kelas,
        'id_prodi' => $json->id_prodi
    ];

    // Update data mahasiswa berdasarkan ID
    if ($model->update($id, $data)) {
        return $this->response->setJSON([
            'status' => 200,
            'message' => 'Data mahasiswa berhasil diupdate',
            'data' => $data
        ]);
    } else {
        return $this->response->setJSON([
            'status' => 400,
            'message' => 'Gagal update data mahasiswa'
        ]);
    }
}
public function delete($id = null)
{
    $model = new MahasiswaModel();

    if ($model->delete($id)) {
        $response = [
            'status' => 200,
            'message' => 'Data Mahasiswa Berhasil Dihapus'
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
    $model = new MahasiswaModel();
    $data = $model->find($id);

    if ($data) {
        // Ambil nama prodi juga
        $prodiModel = new \App\Models\ProdiModel();
        $prodi = $prodiModel->find($data['id_prodi']);
        $data['nama_prodi'] = $prodi ? $prodi['nama_prodi'] : null;

        return $this->respond([
            'status' => 200,
            'message' => 'Data mahasiswa ditemukan',
            'data' => $data
        ]);
    } else {
        return $this->failNotFound('Data mahasiswa tidak ditemukan');
    }
}
public function getAll()
{
    $model = new \App\Models\MahasiswaModel();
    $data = $model->findAll();
    return $this->response->setJSON($data);
}
private function getUser()
{
    $authHeader = $this->request->getHeader("Authorization");
    if (!$authHeader) return null;

    $token = explode(' ', $authHeader->getValue())[1]; // Bearer <token>
    $key = getenv('TOKEN_SECRET');

    return \Firebase\JWT\JWT::decode($token, new \Firebase\JWT\Key($key, 'HS256'));
}
public function getProfil()
{
    $user = $this->getUser(); // Ambil data user dari token
    $email = $user->email;

    $mahasiswaModel = new \App\Models\MahasiswaModel();
    $mahasiswa = $mahasiswaModel->where('email', $email)->first();

    if ($mahasiswa) {
        return $this->response->setJSON([
            'status' => 200,
            'message' => 'Data mahasiswa ditemukan',
            'data' => $mahasiswa
        ]);
    } else {
        return $this->response->setJSON([
            'status' => 404,
            'message' => 'Data mahasiswa tidak ditemukan'
        ]);
    }
}

}
