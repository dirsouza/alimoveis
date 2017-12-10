<?php

namespace ALUImoveis\Models;

use ALUImoveis\Dao\Dao;
use ALUImoveis\Model;

class Immobile extends Model
{
    public static function listAll()
    {
        try {
            $sql = new Dao();
            return $sql->allSelect("SELECT * FROM tbimmobile ORDER BY idImmobile");
        } catch (\PDOException $e) {
            $_SESSION['error'] = array(
                'type' => "danger",
                'ico' => "fa-ban",
                'title' => "Erro",
                'msg' => "Não foi possível recuperar os registros.<br>" . $e->getMessage()
            );
            header("location: /immobile");
            exit;
        }
    }

    public static function immobileId($id)
    {
        try {
            $sql = new Dao();
            return $sql->allSelect("SELECT * FROM tbimmobile WHERE idImmobile = :IDIMMOBILE", array(
                ':IDIMMOBILE' => $id
            ));
        } catch (\PDOException $e) {
            $_SESSION['error'] = array(
                'type' => "danger",
                'ico' => "fa-ban",
                'title' => "Erro",
                'msg' => "Não foi possível recuperar o registro.<br>" . $e->getMessage()
            );
            header('location: /immobile');
            exit;
        }
    }

    public function getData($id)
    {
        try {
            $sql = new Dao();
            $result = $sql->allSelect("SELECT * FROM tbimmobile WHERE idImmobile = :IDIMMOBILE", array(
                ':IDIMMOBILE' => $id
            ));
            $this->setData($result[0]);
        } catch (\PDOException $e) {
            $_SESSION['error'] = array(
                'type' => "danger",
                'ico' => "fa-ban",
                'title' => "Erro",
                'msg' => "Não foi possível recuperar o registro para atualização.<br>" . $e->getMessage()
            );
            header('location: /immobile/update/' . $id);
            exit;
        }
    }

    public function insert()
    {
        if ($this->verifyData()) {
            if ($this->verifyRecord()) {
                $_SESSION['error'] = array(
                    'type' => "warning",
                    'ico' => "fa-warning",
                    'title' => "Aviso",
                    'msg' => "A Descrição do Imóvel informado já foi registrado para outro Imóvel."
                );
                $this->restoreData();
                header("location: /immobile/create");
                exit;
            } else {
                try {
                    $sql = new Dao();
                    $sql->allQuery("INSERT INTO tbimmobile(desDescription, desAddress, desNumber, desDistrict, desZipCode, desCity, desState)
                        VALUES(:DESDESCRIPTION, :DESADDRESS, :DESNUMBER, :DESDISTRICT, :DESZIPCODE, :DESCITY, :DESSTATE)", array(
                        ':DESDESCRIPTION' => $this->getdesDescription(),
                        ':DESADDRESS' => $this->getdesAddress(),
                        ':DESNUMBER' => $this->getdesNumber(),
                        ':DESDISTRICT' => $this->getdesDistrict(),
                        ':DESZIPCODE' => $this->getdesZipCode(),
                        ':DESCITY' => $this->getdesCity(),
                        ':DESSTATE' => $this->getdesState()
                    ));
                    if ($this->verifyInsertData()) {
                        $_SESSION['msg'] = 'insert-success';
                    } else {
                        $_SESSION['msg'] = 'insert-error';
                    }
                } catch (\PDOException $e) {
                    $_SESSION['error'] = array(
                        'type' => "danger",
                        'ico' => "fa-ban",
                        'title' => "Erro",
                        'msg' => "Não foi possível inserir o registro.<br>" . $e->getMessage()
                    );
                    $this->restoreData();
                    header("location: /immobile/create");
                    exit;
                }
            }
        } else {
            $_SESSION['error'] = array(
                'type' => "info",
                'ico' => "fa-info",
                'title' => "Informação",
                'msg' => "Estão faltando dados necessários para o registro."
            );
            $this->restoreData();
            header("location: /immobile/create");
            exit;
        }
    }

    public function update()
    {
        if ($this->verifyData()) {
            $dataBebore = $this->setDataRecover($this->getidImmobile());
            try {
                $sql = new Dao();
                $sql->allQuery("UPDATE tbimmobile SET desDescription = :DESDESCRIPTION, desAddress = :DESADDRESS, desNumber = :DESNUMBER, desDistrict = :DESDISTRICT, desZipCode = :DESZIPCODE, desCity = :DESCITY, desState = :DESSTATE WHERE idImmobile = :IDIMMOBILE", array(
                    ':IDIMMOBILE' => $this->getidImmobile(),
                    ':DESDESCRIPTION' => $this->getdesDescription(),
                    ':DESADDRESS' => $this->getdesAddress(),
                    ':DESNUMBER' => $this->getdesNumber(),
                    ':DESDISTRICT' => $this->getdesDistrict(),
                    ':DESZIPCODE' => $this->getdesZipCode(),
                    ':DESCITY' => $this->getdesCity(),
                    ':DESSTATE' => $this->getdesState()
                ));
                if ($this->compareData($this->getidImmobile(), $dataBebore)) {
                    $_SESSION['msg'] = "update-success";
                } else {
                    $_SESSION['msg'] = "update-info";
                }
            } catch (\PDOException $e) {
                $_SESSION['error'] = array(
                    'type' => "danger",
                    'ico' => "fa-ban",
                    'title' => "Erro",
                    'msg' => "Não foi possível atualizar o registro.<br>" . $e->getMessage()
                );
                header('location: /immobile/update/' . $this->getidImmobile());
                exit;
            }
        } else {
            $_SESSION['error'] = array(
                'type' => "info",
                'ico' => "fa-info",
                'title' => "Informação",
                'msg' => "Estão faltando dados necessários para a atualização do registro."
            );
            header("location: /immobile/update/" . $this->getidImmobile());
            exit;
        }
    }

    public function delete()
    {
        try {
            $sql = new Dao();
            $sql->allQuery("DELETE FROM tbimmobile WHERE idImmobile = :IDIMMOBILE", array(
                ':IDIMMOBILE' => $this->getidImmobile()
            ));
            $dataRecover = $this->setDataRecover($this->getidImmobile());
            if (is_array($dataRecover) && count($dataRecover) > 0) {
                $_SESSION['msg'] = "delete-error";
            } else {
                $_SESSION['msg'] = "delete-success";
            }
        } catch (\PDOException $e) {
            $_SESSION['error'] = array(
                'type' => "danger",
                'ico' => "fa-ban",
                'title' => "Erro",
                'msg' => "Não foi possível deletar o registro.<br>" . $e->getMessage()
            );
            header('location: /immobile');
            exit;
        }
    }

    private function verifyData()
    {
        if (empty(trim($this->getdesDescription()))) {
            return false;
        }

        if (empty(trim($this->getdesAddress()))) {
            return false;
        }

        if (array_key_exists("desNumber", $this->getValues())) {
            if (empty(trim($this->getdesNumber()))) {
                $this->setData(array('desNumber' => "S/N"));
            }
        } else {
            $this->setData(array('desNumber' => "S/N"));
        }

        if (empty(trim($this->getdesDistrict()))) {
            return false;
        }

        if (empty(trim($this->getdesZipCode()))) {
            return false;
        }

        if (empty(trim($this->getdesCity()))) {
            return false;
        }

        if (empty(trim($this->getdesState()))) {
            return false;
        }
        return true;
    }

    private function verifyRecord()
    {
        try {
            $sql = new Dao();
            $result = $sql->allSelect("SELECT * FROM tbimmobile WHERE desDescription = :DESDESCRIPTION", array(
                ':DESDESCRIPTION' => $this->getdesDescription()
            ));

            if (is_array($result) && count($result) > 0) {
                return true;
            }
        } catch (\PDOException $e) {
            $_SESSION['error'] = array(
                'type' => "danger",
                'ico' => "fa-ban",
                'title' => "Erro",
                'msg' => "Não foi possível verificar se a Descrição do Imóvel já consta no Banco de Dados.<br>" . $e->getMessage()
            );
            $this->restoreData();
            header("location: /immobile/create");
            exit;
        }
        return false;
    }

    private function verifyInsertData()
    {
        try {
            $sql = new Dao();
            $result = $sql->allSelect("SELECT * FROM tbimmobile WHERE desDescription = :DESDESCRIPTION", array(
                ':DESDESCRIPTION' => $this->getdesDescription()
            ));

            if (is_array($result) && count($result) > 0) {
                if ($result[0]['desDescription'] === $this->getdesDescription()) {
                    return true;
                }
            }
        } catch (\PDOException $e) {
            throw new \PDOException($e->getMessage());
        }
        return false;
    }

    private function setDataRecover($id)
    {
        try {
            $sql = new Dao();
            $result = $sql->allSelect("SELECT * FROM tbimmobile WHERE idImmobile = :IDIMMOBILE", array(
                ':IDIMMOBILE' => $id
            ));
            if (count($result) > 0) {
                return $result[0];
            } else {
                return 0;
            }
        } catch (\PDOException $e) {
            throw new \PDOException($e->getMessage());
        }
    }

    private function compareData($id, $dataBefore = array())
    {
        $dataAfter = $this->setDataRecover($id);

        $result = array_diff($dataBefore, $dataAfter);

        if (count($result) > 0) {
            return true;
        }

        return false;
    }

    private function restoreData()
    {
        $_SESSION['data'] = array(
            'desDescription' => $this->getdesDescription(),
            'desAddress' => $this->getdesAddress(),
            'desNumber' => $this->getdesNumber(),
            'desDistrict' => $this->getdesDistrict(),
            'desZipCode' => $this->getdesZipCode(),
            'desCity' => $this->getdesCity(),
            'desState' => $this->getdesState()
        );
    }
}