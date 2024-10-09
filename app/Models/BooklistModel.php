<?php

namespace App\Models;

use CodeIgniter\Model;
use Ramsey\Uuid\Uuid;

class BooklistModel extends Model
{
  protected $table = 'booklist';
  protected $useTimestamps = true;
  protected $allowedFields = ['id', 'title', 'category_id', 'category', 'description', 'stock', 'created_by'];

  protected $beforeInsert = ['generateUUID'];

  protected function generateUUID(array $data)
  {
    $uuid = Uuid::uuid4()->toString();
    if (empty($data['data']['id'])) {
      $data['data']['id'] = $uuid; // Menghasilkan UUID
    }
    return $data;
  }

  public function getIdByTitle($title)
  {
    return $this->where('title', $title)->first()['id'];
  }

  public function getBooklistById($id = false)
  {
    if ($id == false) {
      return $this->findAll();
    }
    return $this->where(['id' => $id])->first();
  }
}