<?php

namespace App\Controllers;

use App\Models\ModelHome;
use App\Controllers\BaseController;

class Home extends BaseController
{
    protected ModelHome $ModelHome;

    public function __construct() {
        $this->ModelHome = new ModelHome();
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
            'siswa' => $this->ModelHome->dataSiswa()
        ];
        return view('v_template_front', $data);
    }

    public function updateProfil()
    {
        $id_siswa = session()->get('id_siswa');
        $foto = $this->request->getFile('foto');

        if ($foto->isValid() && !$foto->hasMoved()) {
            $namaFile = $foto->getRandomName();
            $foto->move('foto', $namaFile);
            $this->ModelHome->updateFotoSiswa($id_siswa, $namaFile);
        }

        return redirect()->to(base_url('Home/profile'))->with('success', 'Profile updated successfully.');
    }

    public function kalender(): string
    {
        $data = [
            'judul' => 'Kalender',
            'menu' => 'kalender',
            'page' => 'v_calendar',
            'siswa' => $this->ModelHome->dataSiswa(),
        ];
        return view('v_template_front', $data);
    }
}
