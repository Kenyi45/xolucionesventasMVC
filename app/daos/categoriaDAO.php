<?php
namespace app\Daos;

use Libs\Connection;

class CateriaDAO
{
    public function getAll()
    {
        $pdo = Connection::getInstance()->getConnection();
    }
}