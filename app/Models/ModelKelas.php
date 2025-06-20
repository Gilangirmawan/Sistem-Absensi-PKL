<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelKelas extends Model
{
    protected $table = 'tbl_kelas';
    protected $primaryKey = 'id_kelas';
    protected $allowedFields = ['kelas'];
}
