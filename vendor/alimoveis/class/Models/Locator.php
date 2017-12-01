<?php

namespace ALImoveis\Models;

use ALImoveis\Dao\Dao;
use ALImoveis\Model;

class Locator extends Model
{
    public static function listAll()
    {
        $sql = new Dao();
        return $sql->allSelect("SELECT * FROM tblocator ORDER BY idLocator");
    }

    public static function locatorId()
    {
        $sql = new Dao();
        return $sql->allSelect("SELECT idLocator FROM tblocator ORDER BY idLocator DESC LIMIT 1");
    }

    public function insert()
    {
        $sql = new Dao();

        if ($this->verifyData()) {
            if ($this->verifyLocator()) {
                $_SESSION['error'] = array(
                    'type' => "warning",
                    'ico' => "fa-warning",
                    'title' => "Aviso",
                    'msg' => "O CPF informado já foi registrado para outro Locador."
                );
                header('location: /locator/create');
                exit;
            } else {
                $sql->allQuery("INSERT INTO tblocator(desName, idNation, idMaritalStatus, desProfession, desRG, desCPF)
                VALUES(:DESNAME, :IDNATION, :IDMARITALSTATUS, :DESPROFESSION, :DESRG, :DESCPF)", array(
                    ':DESNAME' => $this->getdesName,
                    ':IDNATION' => $this->getidNation,
                    ':IDMARITALSTATUS' => $this->getidMaritalStatus,
                    ':DESPROFESSION' => $this->getdesProfession,
                    ':DESRG' => $this->getdesRG,
                    ':DESCPF' => $this->getdesCPF
                ));

                header('location: /locator');
                exit;
            }
        } else {
            $_SESSION['error'] = array(
                'type' => "danger",
                'ico' => "fa-ban",
                'title' => "Erro",
                'msg' => "Todos os dados necessários para cadastro não foram informados."
            );
            header('location: /locator/create');
            exit;
        }
    }

    private function verifyData()
    {
        if (empty(trim($this->getdesName))) {
            return false;
        }

        if (empty(trim($this->getidNation))) {
            return false;
        }

        if (empty(trim($this->getidMaritalStatus))) {
            return false;
        }

        if (empty(trim($this->getdesProfession))) {
            return false;
        }

        if (empty(trim($this->getdesRG))) {
            return false;
        }

        if (empty(trim($this->getdesCPF))) {
            return false;
        }

        return true;
    }

    private function verifyLocator()
    {
        $sql = new Dao();

        $result = $sql->allSelect("SELECT * FROM tblocator WHERE desCPF = :DESCPF", array(
            ':DESCPF' => $this->getdesCPF
        ));

        if (count($result) > 0) {
            return true;
        }

        return false;
    }
}