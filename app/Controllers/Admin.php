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

    // public function tambahSiswa()
    // {
    //     $fotoSiswa = $this->request->getFile('foto_siswa');

    //     // Validasi file foto
    //     if (!$fotoSiswa || !$fotoSiswa->isValid()) {
    //         return redirect()->back()->with('error', 'File foto tidak valid atau tidak ada file yang diunggah.');
    //     }

    //     $allowedTypes = ['image/jpeg', 'image/png', 'image/webp'];
    //     if (!in_array($fotoSiswa->getMimeType(), $allowedTypes)) {
    //         return redirect()->back()->with('error', 'Tipe file harus JPEG, PNG, atau WEBP.');
    //     }

    //     if ($fotoSiswa->getSize() > 2 * 1024 * 1024) { // maksimal 2MB
    //         return redirect()->back()->with('error', 'Ukuran file maksimal 2MB.');
    //     }

    //     $namaFoto = $fotoSiswa->getRandomName();
    //     $fotoSiswa->move('uploads', $namaFoto);

    //     // Hash password
    //     $password = password_hash($this->request->getPost('password'), PASSWORD_DEFAULT);

    //     $data = [
    //         'nis'         => $this->request->getPost('nis'),
    //         'nama_siswa'  => $this->request->getPost('nama_siswa'),
    //         'id_kelas'    => $this->request->getPost('id_kelas'),
    //         'username'    => $this->request->getPost('username'),
    //         'password'    => $password,
    //         'foto_siswa'  => $namaFoto,
    //     ];

    //     $this->ModelSiswa->insert($data);
    //     return redirect()->to(base_url('Admin/siswa'))->with('success', 'Data siswa berhasil ditambahkan');
    // }

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
    return redirect()->to(base_url('Admin/siswa'))->with('success', 'Data siswa berhasil diupdate');
}

    // Hapus siswa
    public function hapusSiswa($id_siswa)
    {
        $siswa = $this->ModelSiswa->find($id_siswa);
        if ($siswa && $siswa['foto_siswa'] && file_exists('uploads/' . $siswa['foto_siswa'])) {
            unlink('uploads/' . $siswa['foto_siswa']);
        }

        $this->ModelSiswa->delete($id_siswa);
        return redirect()->to(base_url('Admin/siswa'))->with('success', 'Siswa berhasil dihapus');
    }


}
