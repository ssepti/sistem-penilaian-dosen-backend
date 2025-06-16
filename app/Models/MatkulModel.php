<?php

namespace App\Models;

use CodeIgniter\Model;

class MatkulModel extends Model
{
    protected $table            = 'mata_kuliah';
    protected $primaryKey       = 'id_matkul';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['nama_matkul', 'id_prodi', 'sks'];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    protected array $casts = [];
    protected array $castHandlers = [];

    // Dates
    protected $useTimestamps = false;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];

    public function getMatkul()
    {
        // Query untuk mendapatkan data matkul dengan nama prodi
        return $this->db->table('mata_kuliah')
            ->select('mata_kuliah.id_matkul, mata_kuliah.nama_matkul, mata_kuliah.sks, prodi.nama_prodi') // Pilih kolom yang diperlukan
            ->join('prodi', 'prodi.id_prodi = mata_kuliah.id_prodi') // Lakukan join ke tabel prodi berdasarkan id_prodi
            ->get()
            ->getResultArray();  // Ambil hasilnya dalam bentuk array
    }
}
