<?php

namespace App\Models;

use CodeIgniter\Model;
use Ramsey\Uuid\Uuid;

class CategoryModel extends Model
{
  protected $table = 'category';
  protected $useTimestamps = true;
  protected $allowedFields = ['id', 'name'];

  protected $beforeInsert = ['generateUUID'];

  protected function generateUUID(array $data)
  {
    $uuid = Uuid::uuid4()->toString();
    if (empty($data['data']['id'])) {
      $data['data']['id'] = $uuid; // Menghasilkan UUID
    }
    return $data;
  }

  public function getCategoryById($id = false)
  {
    if ($id == false) {
      return $this->findAll();
    }
    return $this->where(['id' => $id])->first();
  }

  public function getCategoryByName($name)
  {
    return $this->where('name', $name)->first();
  }
}