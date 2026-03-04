<?php

namespace App\Models;

use CodeIgniter\Model;

class InputAspirasiModel extends Model
{
    protected $table            = 'input_aspirasi';
    protected $primaryKey       = 'id_pelaporan';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['nis', 'id_kategori', 'lokasi', 'ket', 'created_at'];

    public function getHistoriSiswa($nis)
    {
        return $this->select('input_aspirasi.*, kategori.ket_kategori as kategori, aspirasi.status, aspirasi.feedback')
            ->join('kategori', 'kategori.id_kategori = input_aspirasi.id_kategori')
            ->join('aspirasi', 'aspirasi.id_pelaporan = input_aspirasi.id_pelaporan', 'left')
            ->where('input_aspirasi.nis', $nis)
            ->orderBy('input_aspirasi.id_pelaporan', 'DESC')
            ->findAll();
    }

    public function getDetailLaporan($id)
    {
        return $this->select('input_aspirasi.*, kategori.ket_kategori, siswa.nama, siswa.kelas')
            ->join('kategori', 'kategori.id_kategori = input_aspirasi.id_kategori')
            ->join('siswa', 'siswa.nis = input_aspirasi.nis')
            ->where('input_aspirasi.id_pelaporan', $id)
            ->first();
    }

    public function getFilteredData($nis = null, $kategori = null, $status = null, $tanggal = null)
    {
        $builder = $this->select('input_aspirasi.*, kategori.ket_kategori, siswa.nama, siswa.kelas, aspirasi.status, aspirasi.feedback')
            ->join('kategori', 'kategori.id_kategori = input_aspirasi.id_kategori')
            ->join('siswa', 'siswa.nis = input_aspirasi.nis')
            ->join('aspirasi', 'aspirasi.id_pelaporan = input_aspirasi.id_pelaporan', 'left');

        if ($nis)      $builder->where('input_aspirasi.nis', $nis);
        if ($kategori) $builder->where('input_aspirasi.id_kategori', $kategori);
        if ($tanggal)  $builder->where('DATE(input_aspirasi.created_at)', $tanggal);

        if ($status) {
            if ($status == 'Menunggu') {
                $builder->groupStart()
                    ->where('aspirasi.status', null)
                    ->orWhere('aspirasi.status', 'Menunggu')
                    ->groupEnd();
            } else {
                $builder->where('aspirasi.status', $status);
            }
        }

        return $builder->orderBy('input_aspirasi.created_at', 'DESC');
    }


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
}
