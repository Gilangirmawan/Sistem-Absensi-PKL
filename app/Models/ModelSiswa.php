<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelSiswa extends Model
{
    protected $table = 'tbl_siswa';
    protected $primaryKey = 'id_siswa';
    protected $allowedFields = ['nis', 'nama_siswa', 'id_kelas', 'username', 'password', 'foto_siswa'];
}
