<?php

namespace App\Models;

use CodeIgniter\Model;

class KunjunganModel extends Model
{
    protected $table            = 'kunjungan';
    protected $primaryKey       = 'id';
    protected $returnType       = 'array';
    
    protected $allowedFields    = ['pendaftaranpasienid', 'jeniskunjungan', 'tglkunjungan'];
    
    protected $useTimestamps    = false;

    // BONUS: Join ke Pendaftaran dan Pasien
    public function getKunjunganLengkap()
    {
        return $this->select('kunjungan.*, pendaftaran.noregistrasi, pasien.nama as nama_pasien')
                    ->join('pendaftaran', 'pendaftaran.id = kunjungan.pendaftaranpasienid')
                    ->join('pasien', 'pasien.id = pendaftaran.pasienid')
                    ->findAll();
    }
}