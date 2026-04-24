<?php

namespace App\Models;

use CodeIgniter\Model;

class PasienModel extends Model
{
    protected $table            = 'pasien';
    protected $primaryKey       = 'id';
    protected $returnType       = 'array';
    protected $allowedFields    = ['nama', 'norm', 'alamat'];
    protected $useTimestamps    = false; // Set true jika tabel punya created_at
}