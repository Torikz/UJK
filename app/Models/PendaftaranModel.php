<?php

namespace App\Models;

use CodeIgniter\Model;

class PendaftaranModel extends Model
{
    protected $table            = 'pendaftaran';
    protected $primaryKey       = 'id';
    protected $returnType       = 'array';
    
    // Field sesuai database
    protected $allowedFields    = ['pasienid', 'noregistrasi', 'tglregistrasi'];
    
    protected $useTimestamps    = false;

    // BONUS: Fungsi untuk mengambil data pendaftaran + Nama Pasien (JOIN)
    // Berguna untuk ditampilkan di DataTables Pendaftaran
    public function getLengkap()
    {
        return $this->select('pendaftaran.*, pasien.nama as nama_pasien, pasien.norm')
                    ->join('pasien', 'pasien.id = pendaftaran.pasienid')
                    ->findAll();
    }
}