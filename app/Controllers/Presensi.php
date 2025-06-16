<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ModelPresensi;

class Presensi extends BaseController
{
    protected $presensiModel;

    public function __construct()
    {
        $this->presensiModel = new ModelPresensi();
    }

    public function index()
    {
        $id_siswa = session()->get('id_siswa');
        $tanggalHariIni = date('Y-m-d');

        // Cek apakah siswa sudah absen hari ini
        $sudahAbsen = $this->presensiModel
            ->where('id_siswa', $id_siswa)
            ->where('tgl_presensi', $tanggalHariIni)
            ->first();

        if (!$sudahAbsen) {
            // Belum absen, tampilkan form absen masuk
            $data = [
                'judul'   => 'Absen Masuk',
                'menu'    => 'presensi',
                'page'    => 'presensi/v_absen_masuk',
                'sekolah' => $this->presensiModel->dataSekolah()
            ];
        } elseif ($sudahAbsen && $sudahAbsen['jam_out'] == null) {
            // Sudah absen masuk tapi belum absen pulang
            $data = [
                'judul'   => 'Absen Pulang',
                'menu'    => 'presensi',
                'page'    => 'presensi/v_absen_pulang',
                'sekolah' => $this->presensiModel->dataSekolah()
            ];
        } else {
            // Sudah absen masuk dan sudah absen pulang
            $data = [
                'judul'   => 'Sudah Absen',
                'menu'    => 'presensi',
                'page'    => 'presensi/v_sudah_absen',
                'sekolah' => $this->presensiModel->dataSekolah()
            ];
        }

        return view('v_template_front', $data);
    }

    public function absenMasuk()
    {
        $id_siswa = session()->get('id_siswa');
        $tanggalHariIni = date('Y-m-d');

        // Cek apakah siswa sudah absen hari ini
        $sudahAbsen = $this->presensiModel
            ->where('id_siswa', $id_siswa)
            ->where('tgl_presensi', $tanggalHariIni)
            ->first();

        if ($sudahAbsen) {
            // Sudah absen, tampilkan halaman 'sudah absen'
            $data = [
                'judul'   => 'Sudah Absen',
                'menu'    => 'presensi',
                'page'    => 'presensi/v_sudah_absen',
                'sekolah' => $this->presensiModel->dataSekolah()
            ];
            return view('v_template_front', $data);
        }

        // Tangkap data dari form
        $lokasi = $this->request->getPost('lokasi');
        $foto   = $this->request->getPost('image');

        // Simpan presensi masuk
        $this->presensiModel->insert([
            'id_siswa'     => $id_siswa,
            'tgl_presensi' => $tanggalHariIni,
            'jam_in'       => date('H:i:s'),
            'lokasi_in'    => $lokasi,
            'foto_in'      => $foto
        ]);

        // Tampilkan halaman konfirmasi sudah absen
        $data = [
            'judul'   => 'Presensi Masuk Berhasil',
            'menu'    => 'presensi',
            'page'    => 'presensi/v_sudah_absen',
            'sekolah' => $this->presensiModel->dataSekolah()
        ];
        return view('v_template_front', $data);
    }

    public function absenPulang()
{
    $id_siswa = session()->get('id_siswa');
    $tanggalHariIni = date('Y-m-d');
    $presensiModel = new ModelPresensi();

    // Ambil data presensi hari ini
    $presensiHariIni = $presensiModel->where('id_siswa', $id_siswa)
                                      ->where('tgl_presensi', $tanggalHariIni)
                                      ->first();

    if (!$presensiHariIni) {
        // Jika belum absen masuk, redirect ke halaman absen masuk
        return redirect()->to(base_url('Presensi'));
    }

    if (!empty($presensiHariIni['jam_out'])) {
        // Jika sudah absen pulang
        $data = [
            'judul' => 'Sudah Absen Pulang',
            'menu' => 'presensi',
            'page' => 'presensi/v_sudah_absen',
            'sekolah' => $presensiModel->dataSekolah()
        ];
        return view('v_template_front', $data);
    }

    // Tangkap data dari form
    $lokasi = $this->request->getPost('lokasi');
    $foto = $this->request->getPost('image');

    // Update presensi dengan data pulang
    $presensiModel->update($presensiHariIni['id_presensi'], [
        'jam_out'     => date('H:i:s'),
        'lokasi_out'  => $lokasi,
        'foto_out'    => $foto
    ]);

    // Tampilkan konfirmasi sudah absen pulang
    $data = [
        'judul' => 'Presensi Pulang Berhasil',
        'menu' => 'presensi',
        'page' => 'presensi/v_sudah_absen',
        'sekolah' => $presensiModel->dataSekolah()
    ];
    return view('v_template_front', $data);
}

}
