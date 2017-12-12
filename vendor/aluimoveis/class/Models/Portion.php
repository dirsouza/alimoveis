<?php

namespace ALUImoveis\Models;

use ALUImoveis\Dao\Dao;
use ALUImoveis\Model;

class Portion extends Model
{
    public static function portionId($id)
    {
        try {
            $sql = new Dao();
            return $sql->allSelect("SELECT * FROM tbportions WHERE idDiscount = :IDDISCOUNT", array(
                ':IDDISCOUNT' => $id
            ));
        } catch (\PDOException $e) {
            $_SESSION['error'] = array(
                'type' => "danger",
                'ico' => "fa-ban",
                'title' => "Erro",
                'msg' => "Não foi possível recuperar o registro.<br>" . $e->getMessage()
            );
            header('location: /discount');
            exit;
        }
    }

    public function insert()
    {
        if ($this->verifyData()) {
            try {
                $sql = new Dao();
                $sql->allQuery("INSERT INTO tbportions(idDiscount, desPortion, dtMaturity, desValue)
                    VALUES(:IDDISCOUNT, :DESPORTION, :DTMATURITY, :DESVALUE)", array(
                    ':IDDISCOUNT' => $this->getidDiscount(),
                    ':DESPORTION' => $this->getdesPortion(),
                    ':DTMATURITY' => $this->getdtMaturity(),
                    ':DESVALUE' => trim(str_replace(",", ".",preg_replace('/[R$.]/',"",$this->getdesValue())))
                ));
            } catch (\PDOException $e) {
                $_SESSION['error'] = array(
                    'type' => "danger",
                    'ico' => "fa-ban",
                    'title' => "Erro",
                    'msg' => "Não foi possível inserir o registro.<br>" . $e->getMessage()
                );
                $this->restoreData();
                header("location: /discount/create");
                exit;
            }
        }
    }

    public function delete($id)
    {
        try {
            $sql = new Dao();
            $sql->allQuery("DELETE FROM tbportions WHERE idDiscount = :IDDISCOUNT", array(
                ':IDDISCOUNT' => $id
            ));
        } catch (\PDOException $e) {
            $_SESSION['error'] = array(
                'type' => "danger",
                'ico' => "fa-ban",
                'title' => "Erro",
                'msg' => "Não foi possível deletar o registro.<br>" . $e->getMessage()
            );
            header('location: /discount');
            exit;
        }
    }

    private function verifyData()
    {
        if (empty(trim($this->getidDiscount()))) {
            return false;
        }

        if (empty(trim($this->getdesPortion()))) {
            return false;
        }

        if (empty(trim($this->getdtMaturity()))) {
            return false;
        }

        if (empty(trim($this->getdesValue()))) {
            return false;
        }
        return true;
    }
}