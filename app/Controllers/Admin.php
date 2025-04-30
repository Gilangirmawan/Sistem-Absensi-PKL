<?php

namespace App\Controllers;

use App\Models\ModelAdmin;
use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class Admin extends BaseController
{
    public function __construct() {
        $this->ModelAdmin = new ModelAdmin();
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

    public function setting(): string
    {
        $data = [
            'judul' => 'Setting',
            'menu' => 'setting',
            'page' => 'backend/v_setting',
            'setting' => $this->ModelAdmin->dataSetting(),
        ];
        return view('v_template_back', $data);
    }

    public function updateSetting()
    {
        $data = [
            'nama_sekolah' => $this->request->getPost('nama_sekolah'),
            'alamat' => $this->request->getPost('alamat'),
            'lokasi_sekolah' => $this->request->getPost('lokasi_sekolah'),
            'radius' => $this->request->getPost('radius'),
        ];
        $this->ModelAdmin->updateSetting($data);
        session()->setFlashdata('pesan', 'Data Berhasil Diupdate');
        return redirect()->to('Admin/setting');
    }
}
