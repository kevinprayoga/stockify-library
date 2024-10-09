<?php

namespace App\Controllers;

class HomeController extends BaseController
{
    public function index(): string
    {
        $data = [
            'title' => 'Home | Stockify'
        ];
        return view('pages/home', $data);
    }
}