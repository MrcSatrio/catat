<?php

namespace App\Models;

use CodeIgniter\Model;

class TransaksiModel extends Model
{
    protected $table      = 'transaksi';
    protected $primaryKey = 'id_transaksi';

    protected $useTimestamps = true;
    protected $allowedFields = ['id_jenis_transaksi', 'id_siswa', 'id_jenis_transaksi', 'nominal_transaksi', 'catatan_transaksi', 'id_status_transaksi', 'bukti_transaksi'];
}

