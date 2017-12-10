<?php

namespace ALUImoveis\Models;

use ALUImoveis\Dao\Dao;
use ALUImoveis\Model;
use ALUImoveis\Models\Validate;

class Renter extends Model
{
    public static function listAll()
    {
        try {
            $sql = new Dao();
            return $sql->allSelect("SELECT * FROM tbrenter ORDER BY idRenter");
        } catch (\PDOException $e) {
            $_SESSION['error'] = array(
                'type' => "danger",
                'ico' => "fa-ban",
                'title' => "Erro",
                'msg' => "Não foi possível recuperar os registros.<br>" . $e->getMessage()
            );
            header("location: /renter");
            exit;
        }
    }

    public static function renterId($id)
    {
        try {
            $sql = new Dao();
            return $sql->allSelect("SELECT * FROM tbrenter WHERE idRenter = :IDRENTER", array(
                ':IDRENTER' => $id
            ));
        } catch (\PDOException $e) {
            $_SESSION['error'] = array(
                'type' => "danger",
                'ico' => "fa-ban",
                'title' => "Erro",
                'msg' => "Não foi possível recuperar o registro.<br>" . $e->getMessage()
            );
            header('location: /renter');
            exit;
        }
    }

    public static function renterDetails($id)
    {
        try {
            $sql = new Dao();
            $result = $sql->allSelect("SELECT	tbrenter.desName,
                                                tbnation.desNationality,
                                                tbmaritalstatus.desMaritalStatus,
                                                tbrenter.desProfession,
                                                tbrenter.desRG,
                                                tbrenter.desCPF
                                        FROM tbrenter INNER JOIN tbnation USING(idNation)
                                        INNER JOIN tbmaritalstatus USING(idMaritalStatus)
                                        WHERE tbrenter.idRenter = :IDRENTER", array(
                                            ':IDRENTER' => $id
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
            $result = $sql->allSelect("SELECT * FROM tbrenter WHERE idRenter = :IDRENTER", array(
                ':IDRENTER' => $id
            ));
            $this->setData($result[0]);
        } catch (\PDOException $e) {
            $_SESSION['error'] = array(
                'type' => "danger",
                'ico' => "fa-ban",
                'title' => "Erro",
                'msg' => "Não foi possível recuperar o registro para atualização.<br>" . $e->getMessage()
            );
            header('location: /renter/update/' . $id);
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
                header("location: /renter/create");
                exit;
            } else {
                if (Validate::validateCPF($this->getdesCPF())) {
                    try {
                        $sql = new Dao();
                        $sql->allQuery("INSERT INTO tbrenter(desName, idNation, idMaritalStatus, desProfession, desRG, desCPF)
                            VALUES(:DESNAME, :IDNATION, :IDMARITALSTATUS, :DESPROFESSION, :DESRG, :DESCPF)", array(
                            ':DESNAME' => $this->getdesName(),
                            ':IDNATION' => $this->getidNation(),
                            ':IDMARITALSTATUS' => $this->getidMaritalStatus(),
                            ':DESPROFESSION' => $this->getdesProfession(),
                            ':DESRG' => $this->getdesRG(),
                            ':DESCPF' => $this->getdesCPF()
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
                        header("location: /renter/create");
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
                    header("location: /renter/create");
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
            header("location: /renter/create");
            exit;
        }
    }

    public function update()
    {
        if ($this->verifyData()) {
            if ($this->verifyCpfRegistered()) {
                if (Validate::validateCPF($this->getdesCPF())) {
                    $dataBebore = $this->setDataRecover($this->getidRenter());
                    try {
                        $sql = new Dao();
                        $sql->allQuery("UPDATE tbrenter SET desName = :DESNAME, idNation = :IDNATION, idMaritalStatus = :IDMARITALSTATUS, desProfession = :DESPROFESSION, desRG = :DESRG, desCPF = :DESCPF WHERE idRenter = :IDRENTER", array(
                            ':IDRENTER' => $this->getidRenter(),
                            ':DESNAME' => $this->getdesName(),
                            ':IDNATION' => $this->getidNation(),
                            ':IDMARITALSTATUS' => $this->getidMaritalStatus(),
                            ':DESPROFESSION' => $this->getdesProfession(),
                            ':DESRG' => $this->getdesRG(),
                            ':DESCPF' => $this->getdesCPF()
                        ));
                        if ($this->compareData($this->getidRenter(), $dataBebore)) {
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
                        header('location: /renter/update/' . $this->getidRenter());
                        exit;
                    }
                } else {
                    $_SESSION['error'] = array(
                        'type' => "warning",
                        'ico' => "fa-warning",
                        'title' => "Aviso",
                        'msg' => "CPF informado para atulização não é válido."
                    );
                    header("location: /renter/update/" . $this->getidRenter());
                    exit;
                }
            } else {
                $_SESSION['error'] = array(
                    'type' => "warning",
                    'ico' => "fa-warning",
                    'title' => "Aviso",
                    'msg' => "CPF informado já foi registrado para outro Locador."
                );
                header("location: /renter/update/" . $this->getidRenter());
                exit;
            }
        } else {
            $_SESSION['error'] = array(
                'type' => "info",
                'ico' => "fa-info",
                'title' => "Informação",
                'msg' => "Estão faltando dados necessários para a atualização do registro."
            );
            header("location: /renter/update/" . $this->getidRenter());
            exit;
        }
    }

    public function delete()
    {
        try {
            $sql = new Dao();
            $sql->allQuery("DELETE FROM tbrenter WHERE idRenter = :IDRENTER", array(
                ':IDRENTER' => $this->getidRenter()
            ));
            $dataRecover = $this->setDataRecover($this->getidRenter());
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
            header('location: /renter');
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

    private function verifyRecord()
    {
        try {
            $sql = new Dao();
            $result = $sql->allSelect("SELECT * FROM tbrenter WHERE desCPF = :DESCPF", array(
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
            header("location: /renter/create");
            exit;
        }
        return false;
    }

    private function verifyCpfRegistered()
    {
        try {
            $sql = new Dao();
            $result = $sql->allSelect("SELECT * FROM tbrenter WHERE desCPF = :DESCPF", array(
                ':DESCPF' => $this->getdesCPF()
            ));

            if (is_array($result) && count($result) > 0) {
                if ($result[0]['idRenter'] === $this->getidRenter()) {
                    return true;
                }
            }
        } catch (\PDOException $e) {
            $_SESSION['error'] = array(
                'type' => "danger",
                'ico' => "fa-ban",
                'title' => "Erro",
                'msg' => "Não foi possível verificar se o CPF informado pertence à ". $this->getdesName() ."<br>" . $e->getMessage()
            );
            header("location: /renter/update/" . $this->getidRenter());
            exit;
        }
        return false;
    }

    private function verifyInsertData()
    {
        try {
            $sql = new Dao();
            $result = $sql->allSelect("SELECT * FROM tbrenter WHERE desCPF = :DESCPF", array(
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
            $result = $sql->allSelect("SELECT * FROM tbrenter WHERE idRenter = :IDRENTER", array(
                ':IDRENTER' => $id
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