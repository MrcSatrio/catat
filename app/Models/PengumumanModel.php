<?php

namespace App\Models;

use CodeIgniter\Model;

class PengumumanModel extends Model
{
    protected $table      = 'pengumuman';
    protected $primaryKey = 'id_pengumuman';
    protected $allowedFields = ['nama_pengumuman'];
}
