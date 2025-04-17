<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ModelAuth;
use CodeIgniter\HTTP\ResponseInterface;

class Auth extends BaseController
{
    public function __construct() {
        $this->ModelAuth = new ModelAuth();
    }
    public function index()
    {
        return view('v_login');
    }

    public function cekLoginSiswa()
    {
        if ($this->validate([
            'username' => [
                'label' => 'Username',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} Tidak Boleh Kosong!'
                ]
            ],
                'password' => [
                'label' => 'Password',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} Tidak Boleh Kosong!'
                ]
            ],
        ])) {
            $username = $this->request->getPost('username');
            $password = sha1($this->request->getPost('password'));

            $cek = $this->ModelAuth->loginSiswa($username, $password);
            if ($cek) {
                session()->set('id_siswa', $cek['id_siswa']);
                session()->set('level', 2 );
                return redirect()->to('Home');
            } else {
                session()->setFlashdata('pesan', 'Username atau Password Salah!');
                return redirect()->to('Auth');
            }
        
        } else {
            return redirect()->to('Auth')->withInput();
        };
    }

    public function logOut()
    {
        session()->destroy();
        return redirect()->to('/');
    }
    public function cekLoginUser()
    {

    }
}
