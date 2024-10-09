<?php

namespace App\Models;

use CodeIgniter\Model;
use Ramsey\Uuid\Uuid;

class RoleModel extends Model
{
  protected $table = 'role';
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

  public function getRoleIdByName($roleName)
  {
    return $this->where('name', $roleName)->first()['id'];
  }
}