<?php

namespace ALUImoveis\Models;

use ALUImoveis\Dao\Dao;
use ALUImoveis\Model;

class Receipt extends Model
{
    public static function listAll()
    {
        try {
            $sql = new Dao();
            return $sql->allSelect("SELECT	tbreceipt.desCode as 'receiptCode',
                                                    tbreceipt.desPaymentInterest,
                                                    tbreceipt.desMonth,
                                                    date_format(tbreceipt.dtSignature, '%d/%m/%Y') as 'dtSignature',
                                                    tbreceipt.desPayment,
                                                    date_format(tbreceipt.dtRegister, '%d/%m/%Y') as 'dtRegister',
                                                    tbcontract.desCode as 'contractCode'
                                            FROM tbreceipt INNER JOIN tbcontract ON tbreceipt.idReceipt = tbcontract.idContract
                                            ORDER BY tbreceipt.desCode ASC");
        } catch (\PDOException $e) {
            $_SESSION['error'] = array(
                'type' => "danger",
                'ico' => "fa-ban",
                'title' => "Erro",
                'msg' => "Não foi possível recuperar os registros.<br>" . $e->getMessage()
            );
            header("location: /receipt");
            exit;
        }
    }

    public static function contractId($id)
    {
        try {
            $sql = new Dao();
            return $sql->allSelect("SELECT * FROM tbcontract WHERE idContract = :IDCONTRACT", array(
                ':IDCONTRACT' => $id
            ));
        } catch (\PDOException $e) {
            $_SESSION['error'] = array(
                'type' => "danger",
                'ico' => "fa-ban",
                'title' => "Erro",
                'msg' => "Não foi possível recuperar o registro.<br>" . $e->getMessage()
            );
            header('location: /contract');
            exit;
        }
    }

    public function getData($id)
    {
        try {
            $sql = new Dao();
            $result = $sql->allSelect("SELECT * FROM tbcontract WHERE idContract = :IDCONTRACT", array(
                ':IDCONTRACT' => $id
            ));
            $this->setData($result[0]);
        } catch (\PDOException $e) {
            $_SESSION['error'] = array(
                'type' => "danger",
                'ico' => "fa-ban",
                'title' => "Erro",
                'msg' => "Não foi possível recuperar o registro para atualização.<br>" . $e->getMessage()
            );
            header('location: /contract/update/' . $id);
            exit;
        }
    }

    public static function viewContract($code)
    {
        try {
            $sql = new Dao();
            $result = $sql->allSelect("SELECT * FROM tbcontract WHERE desCode = :DESCODE", array(
                ':DESCODE' => $code
            ));
            if (is_array($result) && count($result) > 0) {
                return $result[0];
            }
        } catch (\PDOException $e) {
            $_SESSION['error'] = array(
                'type' => "danger",
                'ico' => "fa-ban",
                'title' => "Erro",
                'msg' => "Não foi possível gerar a visualização do Contrato nº " .$code. ".<br>" . $e->getMessage()
            );
            header('location: /contract');
            exit;
        }
    }

    public static function generateCode()
    {
        try {
            $sql = new Dao();
            $generatedCode = $sql->allSelect("SELECT * FROM tbreceipt WHERE desCode = (SELECT MAX(desCode) FROM tbreceipt)");
            if (is_array($generatedCode) && count($generatedCode) > 0) {
                return $generateCode = $generatedCode[0]['desCode'] + 1;
            } else {
                return $generateCode = "0001";
            }
        } catch (\PDOException $e) {
            $_SESSION['error'] = array(
                'type' => "danger",
                'ico' => "fa-ban",
                'title' => "Erro",
                'msg' => "Não foi possível gerar o Código do Contrato.<br>" . $e->getMessage()
            );
            header("location: /contract/create");
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
                    'msg' => "O Imóvel informado já encontra-se locado."
                );
                $this->restoreData();
                header("location: /contract/create");
                exit;
            } else {
                try {
                    $sql = new Dao();
                    $sql->allQuery("INSERT INTO tbcontract(desCode, idLocator, idRenter, idImmobile, desDeadline, dtInitial, dtFinal, desValue)
                        VALUES(:DESCODE, :IDLOCATOR, :IDRENTER, :IDIMMOBILE, :DESDEADLINE, :DTINITIAL, :DTFINAL, :DESVALUE)", array(
                        ':DESCODE' => $this->getdesCode(),
                        ':IDLOCATOR' => $this->getidLocator(),
                        ':IDRENTER' => $this->getidRenter(),
                        ':IDIMMOBILE' => $this->getidImmobile(),
                        ':DESDEADLINE' => $this->getdesDeadline(),
                        ':DTINITIAL' => $this->getdtInitial(),
                        ':DTFINAL' => $this->getdtFinal(),
                        ':DESVALUE' => trim(str_replace(",", ".",preg_replace('/[R$.]/',"",$this->getdesValue())))
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
                    header("location: /contract/create");
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
            header("location: /contract/create");
            exit;
        }
    }

    public function update()
    {
        if ($this->verifyData()) {
            $dataBebore = $this->setDataRecover($this->getidContract());
            try {
                $sql = new Dao();
                $sql->allQuery("UPDATE tbcontract SET desCode = :DESCODE, idLocator = :IDLOCATOR, idRenter = :IDRENTER, idImmobile = :IDIMMOBILE, desDeadline = :DESDEADLINE, dtInitial = :DTINITIAL, dtFinal = :DTFINAL, desValue = :DESVALUE WHERE idContract = :IDCONTRACT", array(
                    ':IDCONTRACT' => $this->getidContract(),
                    ':DESCODE' => $this->getdesCode(),
                    ':IDLOCATOR' => $this->getidLocator(),
                    ':IDRENTER' => $this->getidRenter(),
                    ':IDIMMOBILE' => $this->getidImmobile(),
                    ':DESDEADLINE' => $this->getdesDeadline(),
                    ':DTINITIAL' => $this->getdtInitial(),
                    ':DTFINAL' => $this->getdtFinal(),
                    ':DESVALUE' => trim(str_replace(",", ".",preg_replace('/[R$.]/',"",$this->getdesValue())))
                ));
                if ($this->compareData($this->getidContract(), $dataBebore)) {
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
                header('location: /contract/update/' . $this->getidContract());
                exit;
            }
        } else {
            $_SESSION['error'] = array(
                'type' => "info",
                'ico' => "fa-info",
                'title' => "Informação",
                'msg' => "Estão faltando dados necessários para a atualização do registro."
            );
            header("location: /contract/update/" . $this->getidContract());
            exit;
        }
    }

    public function delete()
    {
        try {
            $sql = new Dao();
            $sql->allQuery("DELETE FROM tbcontract WHERE idContract = :IDCONTRACT", array(
                ':IDCONTRACT' => $this->getidContract()
            ));
            $dataRecover = $this->setDataRecover($this->getidContract());
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
            header('location: /contract');
            exit;
        }
    }

    private function verifyData()
    {
        if (empty(trim($this->getdesCode()))) {
            return false;
        }

        if (empty(trim($this->getidLocator()))) {
            return false;
        }

        if (empty(trim($this->getidRenter()))) {
            return false;
        }

        if (empty(trim($this->getidImmobile()))) {
            return false;
        }

        if (empty(trim($this->getdesDeadline()))) {
            return false;
        }

        if (empty(trim($this->getdtInitial()))) {
            return false;
        }

        if (empty(trim($this->getdtFinal()))) {
            return false;
        }

        if (empty(trim($this->getdesValue()))) {
            return false;
        }
        return true;
    }

    private function verifyRecord()
    {
        try {
            $sql = new Dao();
            $result = $sql->allSelect("SELECT * FROM tbcontract WHERE idImmobile = :IDIMMOBILE", array(
                ':IDIMMOBILE' => $this->getidImmobile()
            ));

            if (is_array($result) && count($result) > 0 && date("Y-m-d") < $this->getdtFinal()) {
                return true;
            }
        } catch (\PDOException $e) {
            $_SESSION['error'] = array(
                'type' => "danger",
                'ico' => "fa-ban",
                'title' => "Erro",
                'msg' => "Não foi possível verificar se o Contrato já consta no Banco de Dados.<br>" . $e->getMessage()
            );
            $this->restoreData();
            header("location: /contract/create");
            exit;
        }
        return false;
    }

    private function verifyInsertData()
    {
        try {
            $sql = new Dao();
            $result = $sql->allSelect("SELECT * FROM tbcontract WHERE desCode = :DESCODE", array(
                ':DESCODE' => $this->getdesCode()
            ));

            if (is_array($result) && count($result) > 0) {
                if ($result[0]['desCode'] === $this->getdesCode()) {
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
            $result = $sql->allSelect("SELECT * FROM tbcontract WHERE idContract = :IDCONTRACT", array(
                ':IDCONTRACT' => $id
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
            'desCode' => $this->getdesCode(),
            'idLocator' => $this->getidLocator(),
            'idRenter' => $this->getidRenter(),
            'idImmobile' => $this->getidImmobile(),
            'desDeadline' => $this->getdesDeadline(),
            'dtInitial' => $this->getdtInitial(),
            'dtFinal' => $this->getdtFinal(),
            'desValue' => $this->getdesValue()
        );
    }

    public static function month()
    {
        return array(
            '1' => 'Janeiro',
            '2' => 'Fevereiro',
            '3' => 'Março',
            '4' => 'Abril',
            '5' => 'Maio',
            '6' => 'Junho',
            '7' => 'Julho',
            '8' => 'Agosto',
            '9' => 'Setembro',
            '10' => 'Outubro',
            '11' => 'Novembro',
            '12' => 'Dezembro'
        );
    }
}