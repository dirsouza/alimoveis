<?php

namespace ALImoveis\Models;

use ALImoveis\Dao\Dao;
use ALImoveis\Model;

class Discount extends Model
{
    public static function listAll()
    {
        try {
            $sql = new Dao();
            return $sql->allSelect("SELECT	tbdiscount.idDiscount,
                                                    tbdiscount.desDescription,
                                                    tbdiscount.idContract,
                                                    tbcontract.desCode AS 'contractCode',
                                                    tbimmobile.desDescription AS 'immobileDescription',
                                                    tbdiscount.desValue,
                                                    tbdiscount.dtRegister
                                            FROM tbdiscount INNER JOIN tbcontract USING(idContract)
                                            INNER JOIN tbimmobile ON tbcontract.idImmobile = tbimmobile.idImmobile");
        } catch (\PDOException $e) {
            $_SESSION['error'] = array(
                'type' => "danger",
                'ico' => "fa-ban",
                'title' => "Erro",
                'msg' => "Não foi possível recuperar os registros.<br>" . $e->getMessage()
            );
            header("location: /discount");
            exit;
        }
    }

    public static function discountId($id)
    {
        try {
            $sql = new Dao();
            return $sql->allSelect("SELECT * FROM tbdiscount WHERE idDiscount = :IDDISCOUNT", array(
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

    public function getData($id)
    {
        try {
            $sql = new Dao();
            $result = $sql->allSelect("SELECT * FROM tbdiscount WHERE idDiscount = :IDDISCOUNT", array(
                ':IDDISCOUNT' => $id
            ));
            $this->setData($result[0]);
        } catch (\PDOException $e) {
            $_SESSION['error'] = array(
                'type' => "danger",
                'ico' => "fa-ban",
                'title' => "Erro",
                'msg' => "Não foi possível recuperar o registro para atualização.<br>" . $e->getMessage()
            );
            header('location: /discount/update/' . $id);
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
                    'msg' => "A Descrição do Desconto informado já foi registrado."
                );
                $this->restoreData();
                header("location: /discount/create");
                exit;
            } else {
                try {
                    $sql = new Dao();
                    $sql->allQuery("INSERT INTO tbdiscount(desDescription, idContract, desValue, desPortion)
                        VALUES(:DESDESCRIPTION, :IDCONTRACT, :DESVALUE, :DESPORTION)", array(
                        ':DESDESCRIPTION' => $this->getdesDescription(),
                        ':IDCONTRACT' => $this->getidContract(),
                        ':DESVALUE' => trim(str_replace(",", ".",preg_replace('/[R$.]/',"",$this->getdesValue()))),
                        ':DESPORTION' => $this->getdesPortion()
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
                    header("location: /discount/create");
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
            header("location: /discount/create");
            exit;
        }
    }

    public function update()
    {
        if ($this->verifyData()) {
            $dataBebore = $this->setDataRecover($this->getidDiscount());
            try {
                $sql = new Dao();
                $sql->allQuery("UPDATE tbdiscount SET desDescription = :DESDESCRIPTION, idContract = :IDCONTRACT, desValue = :DESVALUE, desPortion = :DESPORTION WHERE idDiscount = :IDDISCOUNT", array(
                    ':IDDISCOUNT' => $this->getidDiscount(),
                    ':DESDESCRIPTION' => $this->getdesDescription(),
                    ':IDCONTRACT' => $this->getidContract(),
                    ':DESVALUE' => trim(str_replace(",", ".",preg_replace('/[R$.]/',"",$this->getdesValue()))),
                    ':DESPORTION' => $this->getdesPortion()
                ));
                if ($this->compareData($this->getidDiscount(), $dataBebore)) {
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
                header('location: /discount/update/' . $this->getidDiscount());
                exit;
            }
        } else {
            $_SESSION['error'] = array(
                'type' => "info",
                'ico' => "fa-info",
                'title' => "Informação",
                'msg' => "Estão faltando dados necessários para a atualização do registro."
            );
            header("location: /discount/update/" . $this->getidDiscount());
            exit;
        }
    }

    public function delete()
    {
        try {
            $sql = new Dao();
            $sql->allQuery("DELETE FROM tbdiscount WHERE idDiscount = :IDDISCOUNT", array(
                ':IDDISCOUNT' => $this->getidDiscount()
            ));
            $dataRecover = $this->setDataRecover($this->getidDiscount());
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
            header('location: /discount');
            exit;
        }
    }

    private function verifyData()
    {
        if (empty(trim($this->getdesDescription()))) {
            return false;
        }

        if (empty(trim($this->getidContract()))) {
            return false;
        }

        if (empty(trim($this->getdesValue()))) {
            return false;
        }

        if (empty(trim($this->getdesPortion()))) {
            return false;
        }
        return true;
    }

    private function verifyRecord()
    {
        try {
            $sql = new Dao();
            $result = $sql->allSelect("SELECT * FROM tbdiscount WHERE desDescription = :DESDESCRIPTION", array(
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
                'msg' => "Não foi possível verificar se a Descrição do Desconto já consta no Banco de Dados.<br>" . $e->getMessage()
            );
            $this->restoreData();
            header("location: /discount/create");
            exit;
        }
        return false;
    }

    private function verifyInsertData()
    {
        try {
            $sql = new Dao();
            $result = $sql->allSelect("SELECT * FROM tbdiscount WHERE desDescription = :DESDESCRIPTION", array(
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
            $result = $sql->allSelect("SELECT * FROM tbdiscount WHERE idDiscount = :IDDISCOUNT", array(
                ':IDDISCOUNT' => $id
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
            'idContract' => $this->getidContract(),
            'desValue' => $this->getdesValue(),
            'desPortion' => $this->getdesPortion()
        );
    }
}