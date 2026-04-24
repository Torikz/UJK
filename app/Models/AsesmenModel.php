<?php

namespace App\Models;

use CodeIgniter\Model;

class AsesmenModel extends Model
{
    protected $table            = 'asesmen';
    protected $primaryKey       = 'id';
    protected $returnType       = 'array';
    
    protected $allowedFields    = ['kunjunganid', 'keluhan_utama', 'keluhan_tambahan'];
    
    protected $useTimestamps    = false;

    // BONUS: Join lengkap sampai ke Pasien untuk display data
    public function getAsesmenLengkap()
    {
        return $this->select('asesmen.*, pasien.nama as nama_pasien, kunjungan.tglkunjungan')
                    ->join('kunjungan', 'kunjungan.id = asesmen.kunjunganid')
                    ->join('pendaftaran', 'pendaftaran.id = kunjungan.pendaftaranpasienid')
                    ->join('pasien', 'pasien.id = pendaftaran.pasienid')
                    ->findAll();
    }
}