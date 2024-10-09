<?php

namespace App\Models;

use CodeIgniter\Model;
use Ramsey\Uuid\Uuid;

class UserModel extends Model
{
  protected $table = 'user';
  protected $useTimestamps = true;
  protected $allowedFields = ['id', 'name', 'username', 'password'];

  protected $beforeInsert = ['generateUUID'];

  protected function generateUUID(array $data)
  {
    $uuid = Uuid::uuid4()->toString();
    if (empty($data['data']['id'])) {
      $data['data']['id'] = $uuid; // Menghasilkan UUID
    }
    return $data;
  }

  public function getUser($id = false)
  {
    if ($id == false) {
      return $this->findAll();
    }
    return $this->where(['id' => $id])->first();
  }

  public function getIdByUsername($username)
  {
    return $this->where('username', $username)->first()['id'];
  }

  public function getUserRole($userId)
  {
    $sql = "SELECT role.name as role_name
            FROM user_role
            JOIN role ON role.id = user_role.role_id
            WHERE user_role.user_id = ?";

    $query = $this->db->query($sql, [$userId]);
    $result = $query->getRow();

    return $result ? $result->role_name : null;
  }
}