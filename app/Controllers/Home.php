<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index()
    {
        // Memanggil view layout utama (Wadah SPA)
        return view('layout_main');
    }
}