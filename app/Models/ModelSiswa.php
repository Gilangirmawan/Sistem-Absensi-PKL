<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelSiswa extends Model
{
    protected $table            = 'tbl_siswa';
    protected $primaryKey       = 'id_siswa';
    protected $useAutoIncrement = true;
    protected $allowedFields    = ['nis', 'nama_siswa', 'username', 'password', 'id_kelas', 'foto_siswa'];

    // --- TAMBAHKAN FUNGSI BARU DI SINI ---
    public function getSiswaWithKelas($id_kelas = null)
    {
        $builder = $this->db->table('tbl_siswa');
        $builder->join('tbl_kelas', 'tbl_kelas.id_kelas = tbl_siswa.id_kelas');

        if ($id_kelas) {
            $builder->where('tbl_siswa.id_kelas', $id_kelas);
        }

        return $builder->get()->getResultArray();
    }
}