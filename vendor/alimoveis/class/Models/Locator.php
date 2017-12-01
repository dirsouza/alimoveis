<?php

namespace ALImoveis\Models;

use ALImoveis\Dao\Dao;
use ALImoveis\Model;

class Locator extends Model
{
    public static function listAll()
    {
        try {
            $sql = new Dao();
            return $sql->allSelect("SELECT * FROM tblocator ORDER BY idLocator");
        } catch (\Exception $e) {
            $_SESSION['error'] = array(
                'type' => "danger",
                'ico' => "fa-ban",
                'title' => "Erro",
                'msg' => "Não foi possível recuperar os registros.<br>", $e->getMessage()
            );
            header('location: /locator');
            exit;
        }
    }

    public static function locatorId($id)
    {
        try {
            $sql = new Dao();
            return $sql->allSelect("SELECT * FROM tblocator WHERE idLocator = :IDLOCATOR", array(
                ':IDLOCATOR' => $id
            ));
        } catch (\Exception $e) {
            $_SESSION['error'] = array(
                'type' => "danger",
                'ico' => "fa-ban",
                'title' => "Erro",
                'msg' => "Não foi possível recuperar o registro.<br>", $e->getMessage()
            );
            header('location: /locator');
            exit;
        }
    }

    public function getData($idLocator)
    {
        try {
            $sql = new Dao();
            $restult = $sql->allSelect("SELECT * FROM tblocator WHERE idLocator = :IDLOCATOR", array(
                ':IDLOCATOR' => $idLocator
            ));
            $this->setData($restult[0]);
        } catch (\Exception $e) {
            $_SESSION['error'] = array(
                'type' => "danger",
                'ico' => "fa-ban",
                'title' => "Erro",
                'msg' => "Não foi possível recuperar o registro para atualização.<br>", $e->getMessage()
            );
            header('location: /locator/update/' . $idLocator);
            exit;
        }
    }

    public function insert()
    {
        if ($this->verifyData()) {
            if ($this->verifyLocator()) {
                $_SESSION['error'] = array(
                    'type' => "warning",
                    'ico' => "fa-warning",
                    'title' => "Aviso",
                    'msg' => "CPF informado já foi registrado para outro Locador."
                );
                $this->restoreData();
                header("location: /locator/create");
                exit;
            } else {
                try {
                    $sql = new Dao();
                    $sql->allQuery("INSERT INTO tblocator(desName, idNation, idMaritalStatus, desProfession, desRG, desCPF)
                    VALUES(:DESNAME, :IDNATION, :IDMARITALSTATUS, :DESPROFESSION, :DESRG, :DESCPF)", array(
                        ':DESNAME' => $this->getdesName(),
                        ':IDNATION' => $this->getidNation(),
                        ':IDMARITALSTATUS' => $this->getidMaritalStatus(),
                        ':DESPROFESSION' => $this->getdesProfession(),
                        ':DESRG' => $this->getdesRG(),
                        ':DESCPF' => $this->getdesCPF()
                    ));
                } catch (\Exception $e) {
                    $_SESSION['error'] = array(
                        'type' => "danger",
                        'ico' => "fa-ban",
                        'title' => "Erro",
                        'msg' => "Não foi possível cadastrar o registro.<br>", $e->getMessage()
                    );
                    $this->restoreData();
                    header("location: /locator/create");
                    exit;
                }

                header('location: /locator');
                exit;
            }
        } else {
            $_SESSION['error'] = array(
                'type' => "info",
                'ico' => "fa-info",
                'title' => "Informação",
                'msg' => "Estão faltando dados necessários para o registro."
            );
            $this->restoreData();
            header("location: /locator/create");
            exit;
        }
    }

    public function update()
    {
        try {
            $sql = new Dao();
            $sql->allQuery("UPDATE tblocator SET desName = :DESNAME, idNation = :IDNATION, idMaritalStatus :IDMARITALSTATUS, desProfession = :DESPROFESSION, desRG = :DESRG, desCPF = :DESCPF WHERE idLocator = :IDLOCATOR", array(
                ':IDLOCATOR' => $this->getidLocator(),
                ':DESNAME' => $this->getdesName(),
                ':IDNATION' => $this->getidNation(),
                ':IDMARITALSTATUS' => $this->getidMaritalStatus(),
                ':DESPROFESSION' => $this->getdesProfession(),
                ':DESRG' => $this->getdesRG(),
                ':DESCPF' => $this->getdesCPF()
            ));

            header('location: /locator');
            exit;
        } catch (\Exception $e) {
            $_SESSION['error'] = array(
                'type' => "danger",
                'ico' => "fa-ban",
                'title' => "Erro",
                'msg' => "Não foi possível atualizar o registro.<br>", $e->getMessage()
            );
            $this->restoreData();
            header('location: /locator/update/' . $this->getidLocator());
            exit;
        }
    }

    public function delete()
    {
        try {
            $sql = new Dao();
            $sql->allQuery("DELETE FROM tblocator WHERE idLocator = :IDLOCATOR", array(
                ':IDLOCATOR' => $this->getidLocator()
            ));
        } catch (\Exception $e) {
            $_SESSION['error'] = array(
                'type' => "danger",
                'ico' => "fa-ban",
                'title' => "Erro",
                'msg' => "Não foi possível deletar o registro.<br>", $e->getMessage()
            );
            header('location: /locator');
            exit;
        }
    }

    private function verifyData()
    {
        if (empty(trim($this->getdesName()))) {
            return false;
        }

        if (empty(trim($this->getidNation()))) {
            return false;
        }

        if (empty(trim($this->getidMaritalStatus()))) {
            return false;
        }

        if (empty(trim($this->getdesProfession()))) {
            return false;
        }

        if (empty(trim($this->getdesRG()))) {
            return false;
        }

        if (empty(trim($this->getdesCPF()))) {
            return false;
        }

        return true;
    }

    private function verifyLocator()
    {
        try {
            $sql = new Dao();
            $result = $sql->allSelect("SELECT * FROM tblocator WHERE desCPF = :DESCPF", array(
                ':DESCPF' => $this->getdesCPF()
            ));

            if (count($result) > 0) {
                return true;
            }
        } catch (\Exception $e) {
            $_SESSION['error'] = array(
                'type' => "danger",
                'ico' => "fa-ban",
                'title' => "Erro",
                'msg' => "Não foi possível verificar se o CPF informado já consta no Banco de Dados.<br>", $e->getMessage()
            );
            $this->restoreData();
            header("location: /locator/create");
            exit;
        }

        return false;
    }

    private function restoreData()
    {
        $_SESSION['data'] = array(
            'desName' => $this->getdesName(),
            'idNation' => $this->getidNation(),
            'idMaritalStatus' => $this->getidMaritalStatus(),
            'desProfession' => $this->getdesProfession(),
            'desRG' => $this->getdesRG(),
            'desCPF' => $this->getdesCPF()
        );
    }
}