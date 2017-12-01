<?php

namespace ALImoveis\Models;

use ALImoveis\Dao\Dao;
use ALImoveis\Model;

class Nation extends Model
{
    public static function listAll()
    {
        try {
            $sql = new Dao();
            return $sql->allSelect("SELECT * FROM tbnation ORDER BY idNation");
        } catch (\Exception $e) {
            $_SESSION['error'] = array(
                'type' => "danger",
                'ico' => "fa-ban",
                'title' => "Erro",
                'msg' => "Não foi possível recuperar a lista de Nascionalidades.<br>", $e->getMessage()
            );
            header('location: /locator/create');
            exit;
        }
    }
}