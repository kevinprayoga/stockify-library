<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Models\RoleModel;
use App\Models\UserRoleModel;

class LandingPageController extends BaseController
{
  protected $userModel;
  protected $roleModel;
  protected $userRoleModel;

  public function __construct()
  {
    $this->userModel = new UserModel();
    $this->roleModel = new RoleModel();
    $this->userRoleModel = new UserRoleModel();
  }

  public function login(): string
  {
    return view('landingPage/login');
  }

  public function storeLogin()
  {
    $username = $this->request->getPost('name');
    $password = $this->request->getPost('password');

    // Validasi input
    if (empty($username) || empty($password)) {
      return redirect()->back()->with('error', 'All column is mandatory!');
    }

    // Cek apakah username ada di database
    $user = $this->userModel->where('username', $username)->first();

    if (!$user) {
      return redirect()->back()->with('error', 'Username is unknown!');
    }

    // Verifikasi password
    if (!password_verify($password, $user['password'])) {
      return redirect()->back()->with('error', 'Wrong password!');
    }

    $userRole = $this->userModel->getUserRole($user['id']);

    // Set session untuk login
    session()->set([
      'user_id' => $user['id'],
      'username' => $user['username'],
      'isLoggedIn' => true,
      'role' => $userRole,
    ]);

    return redirect()->to('/')->with('success', 'Login success!');
  }

  public function register(): string
  {
    return view('landingPage/register');
  }

  public function storeRegister()
  {
    // Ambil data dari form
    $name = $this->request->getPost('name');
    $username = $this->request->getPost('username');
    $password = $this->request->getPost('password');

    // Validasi input
    if (empty($name) || empty($username) || empty($password)) {
      return redirect()->back()->with('error', 'All column is mandatory!');
    }

    // Cek apakah username sudah digunakan
    $existingUser = $this->userModel->where('username', $username)->first();
    if ($existingUser) {
      return redirect()->back()->with('error', 'Username is already used!');
    }

    // Hashing password
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Simpan data ke database
    $this->userModel->save([
      'name' => $name,
      'username' => $username,
      'password' => $hashedPassword
    ]);

    // Ambil user_id dari user yang baru saja disimpan
    $userId = $this->userModel->getIdByUsername($username);

    // Dapatkan role_id untuk role 'User'
    $roleId = $this->roleModel->getRoleIdByName('User');

    // Simpan data ke tabel user_role
    $this->userRoleModel->save([
      'user_id' => $userId,
      'role_id' => $roleId
    ]);

    return redirect()->to('/login')->with('success', 'Registration success! Please login.');
  }

  public function logout()
  {
    // Hapus semua session yang berhubungan dengan user
    session()->destroy();

    return redirect()->to('/login')->with('success', "You've been logout.");
  }
}