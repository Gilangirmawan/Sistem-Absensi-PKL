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
                
            ];
            return view('v_template_front', $data);
        }else {
            //Buka Absen Pulang
            $data = [
                'judul' => 'Absen Pulang',
                'menu' => 'presensi',
                'page' => 'presensi/v_absen_pulang',
                
            ];
            return view('v_template_front', $data);
        }
    }
}
