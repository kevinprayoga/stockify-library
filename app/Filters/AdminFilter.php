<?php

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class AdminFilter implements FilterInterface
{
  public function before(RequestInterface $request, $arguments = null)
  {
    // Cek apakah user sudah login
    if (!session()->get('isLoggedIn')) {
      return redirect()->to('/login')->with('error', 'You must be logged in to access this page.');
    }

    // Cek apakah user memiliki role admin
    if (session()->get('role') !== 'Admin') {
      return redirect()->to('/')->with('error', 'You do not have permission to access this page.');
    }
  }

  public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
  {
    // Tidak ada tindakan setelah request
  }
}