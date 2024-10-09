<?php

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class AuthFilter implements FilterInterface
{
  public function before(RequestInterface $request, $arguments = null)
  {
    // Cek apakah pengguna sudah login
    if (!session()->get('isLoggedIn')) {
      // Jika belum login, redirect ke halaman login
      return redirect()->to('/login')->with('error', 'Anda harus login terlebih dahulu!');
    }
  }

  public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
  {
    // Tidak ada aksi yang dilakukan setelah request diproses
  }
}