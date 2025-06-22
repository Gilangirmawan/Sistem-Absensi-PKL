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
        // Jika metode request adalah GET, tampilkan form
        if ($this->request->getMethod() === 'get') {
            $data = [
                'judul' => 'Tambah Siswa',
                'page' => 'backend/v_tambah_siswa', // Path ke view yang sudah diperbaiki
                'kelas' => $this->ModelKelas->findAll(), // Mengambil data kelas untuk dropdown
            ];
            return view('v_template_back', $data);
        }

        // Jika metode request adalah POST, proses data
        if ($this->request->getMethod() === 'post') {
            
            // 1. Aturan Validasi
            $rules = [
                'nis' => [
                    'label' => 'NIS',
                    'rules' => 'required|is_unique[tbl_siswa.nis]',
                    'errors' => ['required' => '{field} wajib diisi.', 'is_unique' => '{field} sudah ada.']
                ],
                'nama_siswa' => [
                    'label' => 'Nama Siswa',
                    'rules' => 'required',
                    'errors' => ['required' => '{field} wajib diisi.']
                ],
                'username' => [
                    'label' => 'Username',
                    'rules' => 'required|is_unique[tbl_siswa.username]',
                    'errors' => ['required' => '{field} wajib diisi.', 'is_unique' => '{field} sudah digunakan.']
                ],
                'id_kelas' => [
                    'label' => 'Kelas',
                    'rules' => 'required',
                    'errors' => ['required' => '{field} wajib dipilih.']
                ],
                'password' => [
                    'label' => 'Password',
                    'rules' => 'required|min_length[6]',
                    'errors' => ['required' => '{field} wajib diisi.', 'min_length' => '{field} minimal 6 karakter.']
                ],
                'foto_siswa' => [
                    'label' => 'Foto Siswa',
                    'rules' => 'uploaded[foto_siswa]|max_size[foto_siswa,1024]|is_image[foto_siswa]|mime_in[foto_siswa,image/jpg,image/jpeg,image/png]',
                    'errors' => [
                        'uploaded' => '{field} wajib diunggah.',
                        'max_size' => 'Ukuran {field} maksimal 1MB.',
                        'is_image' => 'File yang diunggah bukan gambar.',
                        'mime_in' => 'Format {field} harus JPG, JPEG, atau PNG.'
                    ]
                ]
            ];

            // 2. Jalankan Validasi
            if (!$this->validate($rules)) {
                // Jika validasi gagal, kembali ke form dengan pesan error
                // withInput() akan menyimpan input user sebelumnya agar tidak hilang
                return redirect()->back()->withInput()->with('validation', $this->validator);
            }

            // 3. Proses Upload Foto
            $fotoFile = $this->request->getFile('foto_siswa');
            $namaFoto = $fotoFile->getRandomName(); // Buat nama file acak
            $fotoFile->move('uploads/foto_siswa', $namaFoto); // Pindahkan file ke folder public

            // 4. Siapkan Data untuk Disimpan
            $data = [
                'nis'           => $this->request->getPost('nis'),
                'nama_siswa'    => $this->request->getPost('nama_siswa'),
                'username'      => $this->request->getPost('username'),
                'id_kelas'      => $this->request->getPost('id_kelas'),
                // HASHING PASSWORD! Jangan simpan password sebagai plain text.
                'password'      => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
                'foto_siswa'    => $namaFoto,
            ];

            // 5. Simpan ke Database
            $this->ModelSiswa->save($data);

            // 6. Buat Pesan Sukses dan Redirect
            session()->setFlashdata('success', 'Data siswa berhasil ditambahkan.');
            return redirect()->to(base_url('Admin/siswa')); // Arahkan ke halaman daftar siswa
        }
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
