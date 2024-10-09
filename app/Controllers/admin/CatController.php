<?php

namespace App\Controllers\admin;
use App\Controllers\BaseController;
use App\Models\CategoryModel;

class CatController extends BaseController
{
  protected $categoryModel;

  public function __construct()
  {
    $this->categoryModel = new CategoryModel();
  }

  public function index(): string
  {
    // Ambil data kategori dari database
    $categories = $this->categoryModel->findAll();

    // Data yang akan dikirim ke view
    $data = [
      'title' => 'Category',
      'categories' => $categories
    ];

    return view('pages/category/index', $data);
  }

  public function add()
  {
    $name = $this->request->getPost('category_name');

    // Validasi input
    if (empty($name)) {
      return redirect()->back()->with('error', 'Category name is mandatory!');
    }

    // Cek apakah username sudah digunakan
    $existingName = $this->categoryModel->where('name', $name)->first();
    if ($existingName) {
      return redirect()->back()->with('error', 'Category is already used!');
    }

    $this->categoryModel->save(['name' => $name]);

    return redirect()->to('/category')->with('success', 'Category added successfully!');
  }
  
  public function edit()
  {
    $id = $this->request->getPost('category_id');
    $name = $this->request->getPost('category_name');

    // Validasi input
    if (empty($name)) {
      return redirect()->back()->with('error', 'Category name is mandatory!');
    }

    // Cek apakah username sudah digunakan
    $existingName = $this->categoryModel->where('name', $name)->first();
    $sameName = $this->categoryModel->getCategoryById($id);
    if ($existingName && $existingName['name'] != $sameName['name']) {
      return redirect()->back()->with('error', 'Category is already used!');
    }

    $this->categoryModel->update($id, ['name' => $name]);

    return redirect()->to('/category')->with('success', 'Category updated successfully!');
  }
  
  public function delete()
  {
    $id = $this->request->getPost('category_id');

    $this->categoryModel->delete($id);

    return redirect()->to('/category')->with('success', 'Category deleted successfully!');
  }  
}