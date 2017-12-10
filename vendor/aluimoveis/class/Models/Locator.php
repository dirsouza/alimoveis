<?php

namespace ALUImoveis\Models;

use ALUImoveis\Dao\Dao;
use ALUImoveis\Model;
use ALUImoveis\Models\Validate;

class Locator extends Model
{
    public static function listAll()
    {
        try {
            $sql = new Dao();
            return $sql->allSelect("SELECT * FROM tblocator ORDER BY idLocator");
        } catch (\PDOException $e) {
            $_SESSION['error'] = array(
                'type' => "danger",
                'ico' => "fa-ban",
                'title' => "Erro",
                'msg' => "Não foi possível recuperar os registros.<br>" . $e->getMessage()
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
        } catch (\PDOException $e) {
            $_SESSION['error'] = array(
                'type' => "danger",
                'ico' => "fa-ban",
                'title' => "Erro",
                'msg' => "Não foi possível recuperar o registro.<br>" . $e->getMessage()
            );
            header('location: /locator');
            exit;
        }
    }

    public static function locatorDetails($id)
    {
        try {
            $sql = new Dao();
            $result = $sql->allSelect("SELECT	tblocator.desName,
                                                tbnation.desNationality,
                                                tbmaritalstatus.desMaritalStatus,
                                                tblocator.desProfession,
                                                tblocator.desAddress,
                                                tblocator.desNumber,
                                                tblocator.desDistrict,
                                                tblocator.desCity,
                                                tblocator.desState,
                                                tblocator.desZipCode,
                                                tblocator.desRG,
                                                tblocator.desCPF
                                        FROM tblocator INNER JOIN tbnation USING(idNation)
                                        INNER JOIN tbmaritalstatus USING(idMaritalStatus)
                                        WHERE tblocator.idLocator = :IDLOCATOR", array(
                                            ':IDLOCATOR' => $id
                                        ));
            if (is_array($result) && count($result) > 0) {
                return $result[0];
            }
        } catch (\PDOException $e) {
            $_SESSION['error'] = array(
                'type' => "danger",
                'ico' => "fa-ban",
                'title' => "Erro",
                'msg' => "Não foi possível recuperar o registro detalhado.<br>" . $e->getMessage()
            );
            header('location: /contract');
            exit;
        }
    }

    public function getData($id)
    {
        try {
            $sql = new Dao();
            $restult = $sql->allSelect("SELECT * FROM tblocator WHERE idLocator = :IDLOCATOR", array(
                ':IDLOCATOR' => $id
            ));
            $this->setData($restult[0]);
        } catch (\PDOException $e) {
            $_SESSION['error'] = array(
                'type' => "danger",
                'ico' => "fa-ban",
                'title' => "Erro",
                'msg' => "Não foi possível recuperar o registro para atualização.<br>" . $e->getMessage()
            );
            header('location: /locator/update/' . $id);
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
                    'msg' => "CPF informado já foi registrado para outro Locador."
                );
                $this->restoreData();
                header("location: /locator/create");
                exit;
            } else {
                if (Validate::validateCPF($this->getdesCPF())) {
                    try {
                        $sql = new Dao();
                        $sql->allQuery("INSERT INTO tblocator(desName, idNation, idMaritalStatus, desProfession, desRG, desCPF, desZipCode, desAddress, desNumber, desDistrict, desCity, desState)
                            VALUES(:DESNAME, :IDNATION, :IDMARITALSTATUS, :DESPROFESSION, :DESRG, :DESCPF, :DESZIPCODE, :DESADDRESS, :DESNUMBER, :DESDISTRICT, :DESCITY, :DESSTATE)", array(
                                ':DESNAME' => $this->getdesName(),
                                ':IDNATION' => $this->getidNation(),
                                ':IDMARITALSTATUS' => $this->getidMaritalStatus(),
                                ':DESPROFESSION' => $this->getdesProfession(),
                                ':DESRG' => $this->getdesRG(),
                                ':DESCPF' => $this->getdesCPF(),
                                ':DESZIPCODE' => $this->getdesZipCode(),
                                ':DESADDRESS' => $this->getdesAddress(),
                                ':DESNUMBER' => $this->getdesNumber(),
                                ':DESDISTRICT' => $this->getdesDistrict(),
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
                        header("location: /locator/create");
                        exit;
                    }
                } else {
                    $_SESSION['error'] = array(
                        'type' => "warning",
                        'ico' => "fa-warning",
                        'title' => "Aviso",
                        'msg' => "CPF informado não é válido."
                    );
                    $this->restoreData();
                    header("location: /locator/create");
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
            header("location: /locator/create");
            exit;
        }
    }

    public function update()
    {
        if ($this->verifyData()) {
            if ($this->verifyCpfRegistered()) {
                if (Validate::validateCPF($this->getdesCPF())) {
                    $dataBebore = $this->setDataRecover($this->getidLocator());
                    try {
                        $sql = new Dao();
                        $sql->allQuery("UPDATE tblocator SET desName = :DESNAME, idNation = :IDNATION, idMaritalStatus = :IDMARITALSTATUS, desProfession = :DESPROFESSION, desRG = :DESRG, desCPF = :DESCPF, desZipCode = :DESZIPCODE, desAddress = :DESADDRESS, desNumber = :DESNUMBER, desDistrict = :DESDISTRICT, desCity = :DESCITY, desState = :DESSTATE WHERE idLocator = :IDLOCATOR", array(
                            ':IDLOCATOR' => $this->getidLocator(),
                            ':DESNAME' => $this->getdesName(),
                            ':IDNATION' => $this->getidNation(),
                            ':IDMARITALSTATUS' => $this->getidMaritalStatus(),
                            ':DESPROFESSION' => $this->getdesProfession(),
                            ':DESRG' => $this->getdesRG(),
                            ':DESCPF' => $this->getdesCPF(),
                            ':DESZIPCODE' => $this->getdesZipCode(),
                            ':DESADDRESS' => $this->getdesAddress(),
                            ':DESNUMBER' => $this->getdesNumber(),
                            ':DESDISTRICT' => $this->getdesDistrict(),
                            ':DESCITY' => $this->getdesCity(),
                            ':DESSTATE' => $this->getdesState()
                        ));
                        if ($this->compareData($this->getidLocator(), $dataBebore)) {
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
                        header('location: /locator/update/' . $this->getidLocator());
                        exit;
                    }
                } else {
                    $_SESSION['error'] = array(
                        'type' => "warning",
                        'ico' => "fa-warning",
                        'title' => "Aviso",
                        'msg' => "CPF informado para atulização não é válido."
                    );
                    header("location: /locator/update/" . $this->getidLocator());
                    exit;
                }
            } else {
                $_SESSION['error'] = array(
                    'type' => "warning",
                    'ico' => "fa-warning",
                    'title' => "Aviso",
                    'msg' => "CPF informado já foi registrado para outro Locador."
                );
                header("location: /locator/update/" . $this->getidLocator());
                exit;
            }
        } else {
            $_SESSION['error'] = array(
                'type' => "info",
                'ico' => "fa-info",
                'title' => "Informação",
                'msg' => "Estão faltando dados necessários para a atualização do registro."
            );
            header("location: /locator/update/" . $this->getidLocator());
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
            $dataRecover = $this->setDataRecover($this->getidLocator());
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

        if (empty(trim($this->getdesZipCode()))) {
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
            $result = $sql->allSelect("SELECT * FROM tblocator WHERE desCPF = :DESCPF", array(
                ':DESCPF' => $this->getdesCPF()
            ));

            if (count($result) > 0) {
                return true;
            }
        } catch (\PDOException $e) {
            $_SESSION['error'] = array(
                'type' => "danger",
                'ico' => "fa-ban",
                'title' => "Erro",
                'msg' => "Não foi possível verificar se o CPF informado já consta no Banco de Dados.<br>" . $e->getMessage()
            );
            $this->restoreData();
            header("location: /locator/create");
            exit;
        }
        return false;
    }

    private function verifyCpfRegistered()
    {
        try {
            $sql = new Dao();
            $result = $sql->allSelect("SELECT * FROM tblocator WHERE desCPF = :DESCPF", array(
                ':DESCPF' => $this->getdesCPF()
            ));

            if (is_array($result) && count($result) > 0) {
                if ($result[0]['idLocator'] === $this->getidLocator()) {
                    return true;
                }
            }
        } catch (\PDOException $e) {
            $_SESSION['error'] = array(
                'type' => "danger",
                'ico' => "fa-ban",
                'title' => "Erro",
                'msg' => "Não foi possível verificar se o Locador é proprietário do CPF informado.<br>" . $e->getMessage()
            );
            header("location: /locator/update/" . $this->getidLocator());
            exit;
        }
        return false;
    }

    private function verifyInsertData()
    {
        try {
            $sql = new Dao();
            $result = $sql->allSelect("SELECT * FROM tblocator WHERE desCPF = :DESCPF", array(
                ':DESCPF' => $this->getdesCPF()
            ));

            if (is_array($result) && count($result) > 0) {
                if ($result[0]['desCPF'] === $this->getdesCPF()) {
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
            $result = $sql->allSelect("SELECT * FROM tblocator WHERE idLocator = :IDLOCATOR", array(
                ':IDLOCATOR' => $id
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
            'desName' => $this->getdesName(),
            'idNation' => $this->getidNation(),
            'idMaritalStatus' => $this->getidMaritalStatus(),
            'desProfession' => $this->getdesProfession(),
            'desRG' => $this->getdesRG(),
            'desCPF' => $this->getdesCPF()
        );
    }
}