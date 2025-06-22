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
    if ($this->request->getMethod() === 'post') {
        return $this->prosesTambahSiswa();
    }

    $data = [
        'judul' => 'Tambah Siswa',
        'page' => 'backend/v_tambah_siswa',
        'kelas' => $this->ModelKelas->findAll()
    ];
    return view('v_template_back', $data);
}

    public function prosesTambahSiswa()
    {
    if ($this->request->getMethod() === 'POST') {
        $rules = [
            'nis' => 'required|is_unique[tbl_siswa.nis]',
            'nama_siswa' => 'required',
            'username' => 'required|is_unique[tbl_siswa.username]',
            'id_kelas' => 'required',
            'password' => 'required|min_length[6]',
            'foto_siswa' => [
                'rules' => 'max_size[foto_siswa,1024]|is_image[foto_siswa]|mime_in[foto_siswa,image/jpg,image/jpeg,image/png]',
                'errors' => [
                    'max_size' => 'Ukuran foto maksimal 1MB.',
                    'is_image' => 'File bukan gambar.',
                    'mime_in' => 'Format foto harus JPG/JPEG/PNG.'
                ]
            ]
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('validation', $this->validator);
        }

        $fotoFile = $this->request->getFile('foto_siswa');
        $namaFoto = null;

        if ($fotoFile && $fotoFile->isValid() && !$fotoFile->hasMoved()) {
            $namaFoto = $fotoFile->getRandomName();
            $fotoFile->move('uploads/', $namaFoto);
        }

        $data = [
            'nis'         => $this->request->getPost('nis'),
            'nama_siswa'  => $this->request->getPost('nama_siswa'),
            'username'    => $this->request->getPost('username'),
            'id_kelas'    => $this->request->getPost('id_kelas'),
            'password'    => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
            'foto_siswa'  => $namaFoto
        ];

        $this->ModelSiswa->insert($data);
        session()->setFlashdata('success', 'Data siswa berhasil ditambahkan.');
        return redirect()->to(base_url('Admin/siswa'));
    }
}


public function editSiswa($id_siswa)
{
    $siswa = $this->ModelSiswa->find($id_siswa);
    $fotoBaru = $this->request->getFile('foto_siswa');
    $namaFoto = $siswa['foto_siswa'];

    if ($fotoBaru && $fotoBaru->isValid() && !$fotoBaru->hasMoved()) {
        // Hapus foto lama jika ada
        if ($namaFoto && file_exists('uploads/' . $namaFoto)) {
            unlink('uploads/' . $namaFoto);
        }
        $namaFoto = $fotoBaru->getRandomName();
        $fotoBaru->move('uploads/', $namaFoto);
    }

    $passwordInput = $this->request->getPost('password');
    $password = $siswa['password'];
    if (!empty($passwordInput)) {
        $password = password_hash($passwordInput, PASSWORD_DEFAULT);
    }

    $data = [
        'nis'         => $this->request->getPost('nis'),
        'nama_siswa'  => $this->request->getPost('nama_siswa'),
        'id_kelas'    => $this->request->getPost('id_kelas'),
        'username'    => $this->request->getPost('username'),
        'password'    => $password,
        'foto_siswa'  => $namaFoto
    ];

    $this->ModelSiswa->update($id_siswa, $data);
    session()->setFlashdata('success', 'Data siswa berhasil diupdate.');
    return redirect()->to(base_url('Admin/siswa'));
}


    // Hapus siswa
    public function hapusSiswa($id_siswa)
{
    $siswa = $this->ModelSiswa->find($id_siswa);

    if ($siswa && $siswa['foto_siswa']) {
        $fotoPath = 'uploads/' . $siswa['foto_siswa'];
        if (file_exists($fotoPath)) {
            unlink($fotoPath);
        }
    }

    $this->ModelSiswa->delete($id_siswa);
    session()->setFlashdata('success', 'Siswa berhasil dihapus.');
    return redirect()->to(base_url('Admin/siswa'));
}



}
