<?php

namespace App\Models;

use CodeIgniter\Model;

class DosenModel extends Model
{
    protected $table            = 'dosen';
    protected $primaryKey       = 'id_dosen';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['nama_dosen', 'nidn', 'id_prodi', 'id_matkul', 'email'];

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

    public function getDosen()
{
    return $this->db->table('dosen')
    ->select('dosen.id_dosen, dosen.nama_dosen, dosen.nidn, dosen.email, prodi.nama_prodi, mata_kuliah.nama_matkul')
    ->join('prodi', 'prodi.id_prodi = dosen.id_prodi', 'left')
    ->join('mata_kuliah', 'mata_kuliah.id_matkul = dosen.id_matkul', 'left')
    ->join('users', 'users.email = dosen.email', 'left')
    ->get()
    ->getResultArray();

}

}
