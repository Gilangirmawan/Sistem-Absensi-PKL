<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ModelPresensi;


class Presensi extends BaseController
{
    public function __construct()
    {
        $this->ModelPresensi = new ModelPresensi();
    }

    public function index()
    {
        $presensi = $this->ModelPresensi->cekPresensi();
        if ( $presensi == null) {
            //Buka Absen Masuk
            $data = [
                'judul' => 'Absen Masuk',
                'menu' => 'presensi',
                'page' => 'presensi/v_absen_masuk',
                'sekolah' => $this->ModelPresensi->dataSekolah(),
                
            ];
            return view('v_template_front', $data);
        }else {
            //Buka Absen Pulang
            $data = [
                'judul' => 'Absen Pulang',
                'menu' => 'presensi',
                'page' => 'presensi/v_absen_pulang',
                'sekolah' => $this->ModelPresensi->dataSekolah(),
                
            ];
            return view('v_template_front', $data);
        }
    }

    public function absenMasuk()
{
    $siswaId = session()->get('id_siswa');
    $request = $this->request->getJSON();
    
    $lokasi = $request->lokasi;
    $fotoBase64 = $request->foto;
    $tanggal = date('Y-m-d');
    $jam = date('H:i:s');

    $presensiModel = new \App\Models\ModelPresensi();

    // Cek apakah sudah absen masuk
    $sudahAbsen = $presensiModel->where('id_siswa', $siswaId)
        ->where('tgl_presensi', $tanggal)
        ->first();

    if ($sudahAbsen) {
        return $this->response->setJSON(['message' => 'Anda sudah absen masuk hari ini.']);
    }

    // Simpan foto ke file
    $fotoName = 'in_' . $siswaId . '_' . time() . '.jpg';
    $fotoPath = WRITEPATH . 'uploads/' . $fotoName;
    $data = explode(',', $fotoBase64);
    file_put_contents($fotoPath, base64_decode(end($data)));

    // Simpan ke database
    $presensiModel->insert([
        'id_siswa' => $siswaId,
        'tgl_presensi' => $tanggal,
        'jam_in' => $jam,
        'lokasi_in' => $lokasi,
        'foto_in' => $fotoName
    ]);

    return $this->response->setJSON(['message' => 'Absen masuk berhasil!']);
}

public function absenPulang()
{
    $siswaId = session()->get('id_siswa');
    $request = $this->request->getJSON();

    $lokasi = $request->lokasi;
    $fotoBase64 = $request->foto;
    $tanggal = date('Y-m-d');
    $jam = date('H:i:s');

    $presensiModel = new \App\Models\ModelPresensi();

    // Cari data presensi masuk hari ini
    $presensi = $presensiModel->where('id_siswa', $siswaId)
        ->where('tgl_presensi', $tanggal)
        ->first();

    if (!$presensi) {
        return $this->response->setJSON(['message' => 'Anda belum absen masuk hari ini.']);
    }

    if ($presensi['jam_out'] != null && $presensi['jam_out'] != '00:00:00') {
        return $this->response->setJSON(['message' => 'Anda sudah absen pulang hari ini.']);
    }
    

    // Simpan foto pulang
    $fotoName = 'out_' . $siswaId . '_' . time() . '.jpg';
    $fotoPath = WRITEPATH . 'uploads/' . $fotoName;
    $data = explode(',', $fotoBase64);
    file_put_contents($fotoPath, base64_decode(end($data)));

    // Update presensi
    $presensiModel->update($presensi['id_presensi'], [
        'jam_out' => $jam,
        'lokasi_out' => $lokasi,
        'foto_out' => $fotoName
    ]);

    return $this->response->setJSON(['message' => 'Absen pulang berhasil!']);
}


}
