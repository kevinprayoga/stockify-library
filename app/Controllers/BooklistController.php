<?php

namespace App\Controllers;
use App\Models\BooklistModel;
use App\Models\CategoryModel;
use App\Models\BooklistAttachmentModel;

class BooklistController extends BaseController
{
  protected $booklistModel;
  protected $categoryModel;
  protected $booklistAttachmentModel;

  public function __construct()
  {
    $this->booklistModel = new BooklistModel();
    $this->categoryModel = new CategoryModel();
    $this->booklistAttachmentModel = new BooklistAttachmentModel();
  }

  public function index(): string
  {
    if (session()->get('role') === 'Admin') {
      $books = $this->booklistModel->orderBy('title', 'ASC')->findAll();
    } else {
      $books = $this->booklistModel->where('created_by', session()->get('user_id'))->orderBy('title', 'ASC')->findAll();
    }

    // Ambil data kategori dari tabel category dan urutkan berdasarkan nama
    $categories = $this->categoryModel->orderBy('name', 'ASC')->findAll();

    $data = [
      'title' => 'Booklist',
      'books' => $books,
      'categories' => $categories
    ];
    return view('pages/booklist/index', $data);
  }

  public function addBooklist(): string
  {
    // Ambil data kategori dari tabel category dan urutkan berdasarkan nama
    $categories = $this->categoryModel->orderBy('name', 'ASC')->findAll();

    $data = [
      'title' => 'Booklist | Add Booklist',
      'categories' => $categories
    ];
    return view('pages/booklist/addBooklist', $data);
  }

  public function storeBooklist()
  {
    // Validasi dan ambil data dari form
    $judul = $this->request->getPost('judul');
    $kategori_id = $this->request->getPost('kategori');
    $kategori = $this->categoryModel->getCategoryById($kategori_id);
    $deskripsi = $this->request->getPost('deskripsi');
    $jumlah = $this->request->getPost('jumlah');

    // Validasi input
    if (empty($judul)) {
        return redirect()->back()->with('error', 'Title name is mandatory!');
    }
    // Validasi input kategori
    if (!$kategori) {
        return redirect()->back()->with('error', 'Invalid category selected!');
    }

    // Cek apakah judul sudah digunakan
    $existingJudul = $this->booklistModel->where('title', $judul)->first();
    if ($existingJudul) {
        return redirect()->back()->with('error', 'Title is already used!');
    }
    
    // Upload file buku PDF
    $fileBuku = $this->request->getFile('fileBuku');
    $fileBuku->move('file');
    $fileBukuName = $fileBuku->getName();

    // Upload cover buku
    $coverBuku = $this->request->getFile('coverBuku');
    $coverBuku->move('cover');
    $coverBukuName = $coverBuku->getName();

    // Simpan data buku ke dalam database
    $bookData = [
      'title' => $judul,
      'category_id' => $kategori_id,
      'category' => $kategori['name'],
      'description' => $deskripsi,
      'stock' => $jumlah,
      'created_by' => session()->get('user_id'),
    ];
    
    $this->booklistModel->save($bookData);
    $booklistId = $this->booklistModel->getIdByTitle($judul);

    // Simpan data file buku ke dalam tabel booklist_attachment
    $this->booklistAttachmentModel->save([
      'booklist_id' => $booklistId,
      'name' => $fileBukuName,
      'path' => 'public/file/' . $fileBukuName,
      'file_type' => $fileBuku->getClientMimeType(),
      'file_size' => $fileBuku->getSizeByUnit('kb'),
    ]);

    // Simpan data cover buku ke dalam tabel booklist_attachment
    $this->booklistAttachmentModel->save([
      'booklist_id' => $booklistId,
      'name' => $coverBukuName,
      'path' => 'public/cover/' . $coverBukuName,
      'file_type' => $coverBuku->getClientMimeType(),
      'file_size' => $coverBuku->getSizeByUnit('kb'),
    ]);

    return redirect()->to('/booklist')->with('success', 'Book added successfully!');
  }  

  public function detailBooklist($id): string
  {
    // Ambil detail buku berdasarkan id
    $book = $this->booklistModel->find($id);

    // Ambil file attachment untuk booklist tertentu
    $attachments = $this->booklistAttachmentModel->where('booklist_id', $id)->findAll();

    // Pisahkan file dan cover berdasarkan tipe
    $cover = null;
    $file = null;
    foreach ($attachments as $attachment) {
        if (strpos($attachment['file_type'], 'image') !== false) {
            $cover = $attachment;
        } elseif (strpos($attachment['file_type'], 'pdf') !== false) {
            $file = $attachment;
        }
    }

    $data = [
        'title' => 'Booklist | Detail Booklist',
        'book' => $book,
        'cover' => $cover,
        'file' => $file
    ];

    return view('pages/booklist/detailBooklist', $data);
  }  

  public function downloadFile($filename)
  {
      // Path ke file yang disimpan di public/file
      $filePath = FCPATH . 'file/' . $filename;
  
      if (!file_exists($filePath)) {
          return redirect()->back()->with('error', 'File not found!');
      }
  
      // Menggunakan fungsi download bawaan CodeIgniter
      return $this->response->download($filePath, null)->setFileName($filename);
  }

  public function editBooklist($id): string
  {
    // Ambil detail buku yang akan diedit
    $book = $this->booklistModel->find($id);

    // Ambil file attachment untuk booklist tertentu
    $attachments = $this->booklistAttachmentModel->where('booklist_id', $id)->findAll();

    // Pisahkan file dan cover berdasarkan tipe
    $cover = null;
    $file = null;
    foreach ($attachments as $attachment) {
        if (strpos($attachment['file_type'], 'image') !== false) {
            $cover = $attachment;
        } elseif (strpos($attachment['file_type'], 'pdf') !== false) {
            $file = $attachment;
        }
    }

    // Ambil data kategori dari tabel category dan urutkan berdasarkan nama
    $categories = $this->categoryModel->orderBy('name', 'ASC')->findAll();

    $data = [
        'title' => 'Booklist | Edit Booklist',
        'book' => $book,
        'cover' => $cover,
        'file' => $file,
        'categories' => $categories,
    ];

    return view('pages/booklist/editBooklist', $data);
  }
  
  public function updateBooklist($id)
  {
      // Ambil data dari form
      $judul = $this->request->getPost('judul');
      $kategori_id = $this->request->getPost('kategori');
      $deskripsi = $this->request->getPost('deskripsi');
      $jumlah = $this->request->getPost('jumlah');
  
      // Validasi input kategori
      $kategori = $this->categoryModel->find($kategori_id);
      if (!$kategori) {
          return redirect()->back()->with('error', 'Invalid category selected!');
      }
  
      // Validasi input
      if (empty($judul)) {
          return redirect()->back()->with('error', 'Title name is mandatory!');
      }
  
      // Cek apakah judul sudah digunakan
      $existingTitle = $this->booklistModel->where('title', $judul)->first();
      $sameTitle = $this->booklistModel->getBooklistById($id);
      if ($existingTitle && $existingTitle['title'] != $sameTitle['title']) {
          return redirect()->back()->with('error', 'Title is already used!');
      }
  
      // Perbarui data buku di database
      $bookData = [
          'title' => $judul,
          'category_id' => $kategori_id,
          'category' => $kategori['name'],
          'description' => $deskripsi,
          'stock' => $jumlah,
          'created_by' => session()->get('user_id'),
      ];
  
      $this->booklistModel->update($id, $bookData);
  
      // Periksa apakah ada file PDF baru yang diunggah
      $fileBuku = $this->request->getFile('fileBuku');
      if ($fileBuku !== null && $fileBuku->isValid()) {
          $fileBuku->move('file');
          $fileBukuName = $fileBuku->getName();
  
          // // Hapus file lama dari server jika ada
          // $oldFile = $this->booklistAttachmentModel->where(['booklist_id' => $id, 'file_type' => 'application/pdf'])->first();
          // if ($oldFile && file_exists($oldFile['path'])) {
          //     unlink($oldFile['path']); // Hapus file lama dari server
          //     $this->booklistAttachmentModel->delete($oldFile['id']); // Hapus dari database
          // }

          // Hapus file lama dari server jika ada
          $oldFiles = $this->booklistAttachmentModel->where('booklist_id', $id)->findAll();
          foreach ($oldFiles as $oldFile) {
              if (strpos($oldFile['file_type'], 'pdf') !== false) {
                  $filePath = FCPATH . 'file/' . $oldFile['name'];
                  if (file_exists($filePath)) {
                    unlink($filePath);
                    $this->booklistAttachmentModel->delete($oldFile['id']); // Hapus dari database
                  }
              }
          }
  
          // Simpan file baru ke database
          $this->booklistAttachmentModel->save([
              'booklist_id' => $id,
              'name' => $fileBukuName,
              'path' => 'public/file/' . $fileBukuName,
              'file_type' => $fileBuku->getClientMimeType(),
              'file_size' => $fileBuku->getSizeByUnit('kb'),
          ]);
      }
  
      // Periksa apakah ada cover baru yang diunggah
      $coverBuku = $this->request->getFile('coverBuku');
      if ($coverBuku !== null && $coverBuku->isValid()) {
          $coverBuku->move('cover');
          $coverBukuName = $coverBuku->getName();
  
          // Hapus cover lama dari server jika ada
          $oldCovers = $this->booklistAttachmentModel->where('booklist_id', $id)->findAll();
          foreach ($oldCovers as $oldCover) {
              if (strpos($oldCover['file_type'], 'image') !== false) {
                $filePath = FCPATH . 'cover/' . $oldCover['name'];
                if (file_exists($filePath)) {
                  unlink($filePath);
                  $this->booklistAttachmentModel->delete($oldCover['id']); // Hapus dari database
                }
              }
          }
  
          // Simpan cover baru ke database
          $this->booklistAttachmentModel->save([
              'booklist_id' => $id,
              'name' => $coverBukuName,
              'path' => 'public/cover/' . $coverBukuName,
              'file_type' => $coverBuku->getClientMimeType(),
              'file_size' => $coverBuku->getSizeByUnit('kb'),
          ]);
      }
  
      return redirect()->to('/booklist')->with('success', 'Book updated successfully!');
  }

  public function deleteBooklist($id)
  {
    // Cari informasi attachment terkait
    $attachments = $this->booklistAttachmentModel->where('booklist_id', $id)->findAll();

    // Hapus file terkait dari server
    foreach ($attachments as $attachment) {
      $filePath = $attachment['path'];
      if (file_exists($filePath)) {
          unlink($filePath);
      }
    }

    // Hapus data buku dan attachment dari database
    $this->booklistModel->delete($id);
    $this->booklistAttachmentModel->where('booklist_id', $id)->delete();

    return redirect()->to('/booklist')->with('success', 'Booklist deleted successfully!');
  }
  
}  