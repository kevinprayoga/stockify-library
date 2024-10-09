<?php

namespace App\Models;

use CodeIgniter\Model;
use Ramsey\Uuid\Uuid;

class BooklistAttachmentModel extends Model
{
  protected $table = 'booklist_attachment';
  protected $useTimestamps = true;
  protected $allowedFields = ['id', 'booklist_id', 'name', 'path', 'file_type', 'file_size'];

  protected $beforeInsert = ['generateUUID'];

  protected function generateUUID(array $data)
  {
    $uuid = Uuid::uuid4()->toString();
    if (empty($data['data']['id'])) {
      $data['data']['id'] = $uuid; // Menghasilkan UUID
    }
    return $data;
  }
}