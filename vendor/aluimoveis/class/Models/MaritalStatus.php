<?php

namespace ALUImoveis\Models;

use ALUImoveis\Dao\Dao;
use ALUImoveis\Model;

class MaritalStatus extends Model
{
    public static function listAll()
    {
        try {
            $sql = new Dao();
            return $sql->allSelect("SELECT * FROM tbmaritalstatus ORDER BY idMaritalStatus");
        } catch (\Exception $e) {
            $_SESSION['error'] = array(
                'type' => "danger",
                'ico' => "fa-ban",
                'title' => "Erro",
                'msg' => "Não foi possível recuperar a lista de Estados Civis.<br>" . $e->getMessage()
            );
            header('location: /locator/create');
            exit;
        }
    }
}