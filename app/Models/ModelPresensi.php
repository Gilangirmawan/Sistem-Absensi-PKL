<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelPresensi extends Model 
{
    public function cekPresensi()
    {
        return $this->db->table('tbl_presensi')
        ->where('id_siswa', session()->get('id_siswa'))
        ->where('tgl_presensi', date('Y-m-d'))
        ->get()->getRowArray();
    }

    public function dataSekolah()
    {
        return $this->db->table('tbl_setting')->where('id_setting', 1)->get()->getRowArray();
    }
}
