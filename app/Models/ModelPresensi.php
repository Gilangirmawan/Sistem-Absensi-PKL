<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelPresensi extends Model 
{

    protected $table = 'tbl_presensi';
    protected $primaryKey = 'id_presensi';
    protected $allowedFields = [
        'id_siswa', 'tgl_presensi', 'jam_in', 'jam_out',
        'lokasi_in', 'lokasi_out', 'foto_in', 'foto_out'
    ];
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
