<?php

namespace App\Models;

use CodeIgniter\Model;
use Ramsey\Uuid\Uuid;

class UserRoleModel extends Model
{
  protected $table = 'user_role';
  protected $allowedFields = ['id', 'user_id', 'role_id'];

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