<?php

namespace App\Controllers;

use App\Models\ModelHome;
use App\Models\ModelPresensi;
use App\Controllers\BaseController;

class Home extends BaseController
{
    protected ModelHome $ModelHome;
    protected ModelPresensi $ModelPresensi;
    
    public function __construct() {
        $this->ModelHome = new ModelHome();
        $this->ModelPresensi = new ModelPresensi();
    }

    public function index(): string
    {
        $data = [
            'judul' => 'Home',
            'menu' => 'home',
            'page' => 'v_home',
            'siswa' => $this->ModelHome->dataSiswa(),
        ];
        return view('v_template_front', $data);
    }

    public function profile(): string
    {
        $data = [
            'judul' => 'Profile',
            'menu' => 'profile',
            'page' => 'v_profile',
            'siswa' => $this->ModelHome->dataSiswa(),
        ];
        return view('v_template_front', $data);
    }

    public function updateFoto()
    {
        $siswaId = session()->get('id_siswa');
        if (!$siswaId) {
            return redirect()->to('/')->with('error', 'Session tidak ditemukan. Silakan login ulang.');
        } 

        $file = $this->request->getFile('foto_siswa');
        if (!$file || !$file->isValid()) {
            return redirect()->back()->with('error', 'File tidak valid atau tidak ada file yang diunggah.');
        }

        $allowedTypes = ['image/jpeg', 'image/png', 'image/webp'];
        if (!in_array($file->getMimeType(), $allowedTypes)) {
            return redirect()->back()->with('error', 'Tipe file harus JPEG, PNG, atau WEBP.');
        }

        if ($file->getSize() > 2 * 1024 * 1024) { // maksimal 2MB
            return redirect()->back()->with('error', 'Ukuran file maksimal 2MB.');
        }

        $siswa = $this->ModelHome->dataSiswa();
        if ($siswa && !empty($siswa['foto_siswa'])) {
            $oldPath = FCPATH . 'uploads/' . $siswa['foto_siswa'];
            if (file_exists($oldPath)) {
                unlink($oldPath);
            }
        }

        $newName = $file->getRandomName();
        if (!$file->move(FCPATH . 'uploads/', $newName)) {
            return redirect()->back()->with('error', 'Gagal menyimpan file.');
        }

        $this->ModelHome->updateFotoSiswa($siswaId, $newName);
        return redirect()->to('/home/profile')->with('success', 'Foto profil berhasil diperbarui.');
    }


    public function kalender()
{
    $id_siswa = session()->get('id_siswa');
    $tanggalMulai = new \DateTime(TGL_MULAI_PKL);
    $tanggalHariIni = new \DateTime();

    $modelPresensi = new ModelPresensi();
    $events = [];

    $interval = new \DateInterval('P1D');
    $periode = new \DatePeriod($tanggalMulai, $interval, $tanggalHariIni->modify('+1 day'));

    foreach ($periode as $tanggal) {
        $tanggalStr = $tanggal->format('Y-m-d');

        // Lewati weekend (6 = Sabtu, 7 = Minggu)
        if (in_array($tanggal->format('N'), [6, 7])) {
            continue;
        }

        $presensi = $modelPresensi
            ->where('id_siswa', $id_siswa)
            ->where('tgl_presensi', $tanggalStr)
            ->first();

        if ($presensi) {
            // Gunakan nilai numerik dari field 'keterangan'
            switch ((int)$presensi['keterangan']) {
                case 1:
                    $color = 'green';
                    $title = 'Hadir';
                    break;
                case 2:
                    $color = 'orange';
                    $title = 'Izin/Sakit';
                    break;
                case 0:
                default:
                    $color = 'orange';
                    $title = 'Tidak Lengkap';
                    break;
            }
        } else {
            $color = 'red';
            $title = 'Alfa';
        }

        $events[] = [
            'title' => $title,
            'start' => $tanggalStr,
            'color' => $color,
        ];
    }

    $data = [
        'judul' => 'Kalender Kehadiran',
        'menu' => 'kalender',
        'page' => 'v_kalender',
        'events' => json_encode($events),
    ];

    return view('v_template_front', $data);
}





}
