<?php

namespace App\Models;

use CodeIgniter\Model;

class jenistransaksiModel extends Model
{
    protected $table      = 'jenis_transaksi';
    protected $primaryKey = 'id_jenis_transaksi';
    protected $allowedFields = ['nama_jenis_transaksi'];
}
