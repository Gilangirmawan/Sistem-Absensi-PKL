<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelHome extends Model
{
    public function dataSiswa()
    {
        return $this->db->table('tbl_siswa')
        ->join('tbl_kelas','tbl_kelas.id_kelas=tbl_siswa.id_kelas', 'LEFT')
        ->where(
            'id_siswa', session()->get('id_siswa'))->get()->getRowArray();
    }
}
