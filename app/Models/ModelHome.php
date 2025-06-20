<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelHome extends Model
{
    protected $table = 'tbl_siswa';
    protected $primaryKey = 'id_siswa';
    protected $returnType = 'array';

    /**
     * Mengambil data lengkap siswa yang sedang login.
     *
     * @return array|null
     */
    public function dataSiswa(): ?array
    {
        $idSiswa = session()->get('id_siswa');

        return $this->select('tbl_siswa.*, tbl_kelas.kelas')
                    ->join('tbl_kelas', 'tbl_kelas.id_kelas = tbl_siswa.id_kelas', 'left')
                    ->where('tbl_siswa.id_siswa', $idSiswa)
                    ->first();
    }

    public function updateFotoSiswa($id_siswa, $foto)
{
    return $this->db->table('tbl_siswa')
        ->where('id_siswa', $id_siswa)
        ->update(['foto_siswa' => $foto]);
}


}
