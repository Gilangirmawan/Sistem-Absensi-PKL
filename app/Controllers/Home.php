<?php

namespace App\Controllers;

use App\Models\ModelHome;
use App\Controllers\BaseController;

class Home extends BaseController
{
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
        ];
        return view('v_template_front', $data);
    }
}
