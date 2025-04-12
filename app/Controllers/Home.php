<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index(): string
    {
        $data = [
            'judul' => 'Home',
            'menu' => 'home',
            'page' => 'v_home',
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
