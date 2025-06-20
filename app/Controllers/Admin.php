<?php

namespace App\Controllers;

use App\Models\ModelAdmin;
use App\Controllers\BaseController;
use App\Models\ModelSiswa;
use App\Models\ModelKelas;
use CodeIgniter\HTTP\Files\UploadedFile;
use CodeIgniter\HTTP\ResponseInterface;

class Admin extends BaseController
{
    protected ModelAdmin $ModelAdmin;
    protected ModelSiswa $ModelSiswa;
    protected ModelKelas $ModelKelas;

    public function __construct() {
        $this->ModelAdmin = new ModelAdmin();
        $this->ModelSiswa = new ModelSiswa();
        $this->ModelKelas = new ModelKelas();
        helper(['form', 'url']);
    }
    

    public function index(): string
    {
        $data = [
            'judul' => 'Dashboard',
            'menu' => 'dashboard',
            'page' => 'backend/v_dashboard',
        ];
        return view('v_template_back', $data);
    }

    public function siswa()
    {
        $filterKelas = $this->request->getGet('kelas');
        $dataKelas = $this->ModelKelas->findAll();

        if ($filterKelas) {
            $dataSiswa = $this->ModelSiswa
                ->where('id_kelas', $filterKelas)
                ->join('tbl_kelas', 'tbl_kelas.id_kelas = tbl_siswa.id_kelas')
                ->findAll();
        } else {
            $dataSiswa = $this->ModelSiswa
                ->join('tbl_kelas', 'tbl_kelas.id_kelas = tbl_siswa.id_kelas')
                ->findAll();
        }

        $data = [
            'judul' => 'Manajemen Siswa',
            'page' => 'backend/v_siswa',
            'siswa' => $dataSiswa,
            'kelas' => $dataKelas,
            'filterKelas' => $filterKelas,
        ];

        return view('v_template_back', $data);
    }

    public function tambahSiswa()
{
    $foto = $this->request->getFile('foto_siswa');

    if ($foto && $foto->isValid() && !$foto->hasMoved()) {
        $namaFoto = $foto->getRandomName();
        $foto->move('uploads', $namaFoto);
    } else {
        $namaFoto = null;
    }

    $data = [
        'nis'         => $this->request->getPost('nis'),
        'nama_siswa'  => $this->request->getPost('nama_siswa'),
        'id_kelas'    => $this->request->getPost('id_kelas'),
        'username'    => $this->request->getPost('username'),
        'password'    => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
        'foto_siswa'  => $namaFoto,
    ];

    $this->ModelSiswa->insert($data);
    return redirect()->to(base_url('backend/v_siswa'))->with('success', 'Siswa berhasil ditambahkan');
}

public function editSiswa($id_siswa)
{
    $siswa = $this->ModelSiswa->find($id_siswa);
    $fotoBaru = $this->request->getFile('foto_siswa');

    // Cek apakah admin ingin ganti foto
    if ($fotoBaru && $fotoBaru->isValid() && !$fotoBaru->hasMoved()) {
        // Hapus foto lama jika ada
        if ($siswa['foto_siswa'] && file_exists('uploads/' . $siswa['foto_siswa'])) {
            unlink('uploads/' . $siswa['foto_siswa']);
        }

        $namaFoto = $fotoBaru->getRandomName();
        $fotoBaru->move('uploads', $namaFoto);
    } else {
        $namaFoto = $siswa['foto_siswa']; // pakai foto lama
    }

    // Cek apakah admin mengubah password
    $passwordInput = $this->request->getPost('password');
    if (!empty($passwordInput)) {
        $password = password_hash($passwordInput, PASSWORD_DEFAULT);
    } else {
        $password = $siswa['password']; // pakai password lama
    }

    $data = [
        'nis'         => $this->request->getPost('nis'),
        'nama_siswa'  => $this->request->getPost('nama_siswa'),
        'id_kelas'    => $this->request->getPost('id_kelas'),
        'username'    => $this->request->getPost('username'),
        'password'    => $password,
        'foto_siswa'  => $namaFoto,
    ];

    $this->ModelSiswa->update($id_siswa, $data);
    return redirect()->to(base_url('backend/v_siswa'))->with('success', 'Data siswa berhasil diupdate');
}


}
