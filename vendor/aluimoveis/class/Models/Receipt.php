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
            return $sql->allSelect("SELECT	tbreceipt.idReceipt,
                                                    tbreceipt.desCode AS 'receiptCode',
                                                    tbrenter.desName AS 'renterName',
                                                    tbreceipt.desInterest,
                                                    tbreceipt.desMonth,
                                                    tbreceipt.desPayment,
                                                    date_format(tbreceipt.dtRegister, '%d/%m/%Y') AS 'dtRegister',
                                                    tbcontract.desCode AS 'contractCode',
                                                    tbimmobile.desDescription AS 'immobileDescription'
                                            FROM tbreceipt
                                            INNER JOIN tbcontract USING(idContract)
                                            INNER JOIN tbrenter ON tbrenter.idRenter = tbcontract.idRenter
                                            INNER JOIN tbimmobile ON tbcontract.idImmobile = tbimmobile.idImmobile 
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

    public static function receiptId($id)
    {
        try {
            $sql = new Dao();
            return $sql->allSelect("SELECT * FROM tbreceipt WHERE idReceipt = :IDRECEIPT", array(
                ':IDRECEIPT' => $id
            ));
        } catch (\PDOException $e) {
            $_SESSION['error'] = array(
                'type' => "danger",
                'ico' => "fa-ban",
                'title' => "Erro",
                'msg' => "Não foi possível recuperar o registro.<br>" . $e->getMessage()
            );
            header('location: /receipt');
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
            header('location: /receipt/update/' . $id);
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
                'msg' => "Não foi possível gerar o Código do Recibo.<br>" . $e->getMessage()
            );
            header("location: /receipt/create");
            exit;
        }
    }

    public static function searchLastPayment($idContract)
    {
        try {
            $sql = new Dao();
            $result = $sql->allSelect(
                "SELECT desMonth FROM tbreceipt WHERE idContract = :IDCONTRACT", array(
                ':IDCONTRACT' => $idContract
            ));

            if (is_array($result) && count($result) > 0) {
                return $result;
            }
        } catch (\PDOException $e) {
            $_SESSION['error'] = array(
                'type' => "danger",
                'ico' => "fa-ban",
                'title' => "Erro",
                'msg' => "Não foi possível verificar o último pagamento.<br>" . $e->getMessage()
            );
            header("location: /receipt/create");
            exit;
        }
    }

    public static function searchPortions(int $id)
    {
        try {
            $sql = new Dao();
            $result = $sql->allSelect("SELECT idDiscount FROM tbdiscount WHERE idContract = :IDCONTRACT", array(
                ':IDCONTRACT' => $id
            ));

            $results = array();

            if (is_array($result) && count($result) > 0) {
                foreach ($result as $key => $index) {
                    foreach ($index as $idValue) {
                        $discounts = $sql->allSelect("SELECT tbdiscount.desDescription AS 'discountDescription',
                                                                    tbportions.idPortions AS 'portionsId',
                                                                    tbportions.dtMaturity AS 'portionsMaturity',
                                                                    tbportions.desValue AS 'portionsValue',
                                                                    tbportions.desPayment
                                                             FROM tbportions INNER JOIN tbdiscount USING(idDiscount)
                                                             WHERE tbportions.idDiscount = $idValue
                                                             ORDER BY tbportions.idPortions ASC");

                        if (is_array($discounts) && count($discounts) > 0) {
                            array_push($results, $discounts);
                        }
                    }
                }
            }

            if (is_array($results) && count($results) > 0) {
                return $results;
            }
        } catch (\PDOException $e) {
            $_SESSION['error'] = array(
                'type' => "danger",
                'ico' => "fa-ban",
                'title' => "Erro",
                'msg' => "Não foi possível verificar se existem Descontos.<br>" . $e->getMessage()
            );
            header("location: /receipt/create");
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
                    'msg' => "Já existe um Recibo gerado para esse período."
                );
                $this->restoreData();
                header("location: /receipt/create");
                exit;
            } else {
                try {
                    $sql = new Dao();
                    $sql->allQuery("INSERT INTO tbreceipt(desCode, idContract, desFined, desInterest, desPortions, desMonth, desValue, desNote, desPayment)
                        VALUES(:DESCODE, :IDCONTRAC, :DESFINED, :DESINTEREST, :DESPORTIONS, :DESMONTH, :DESVALUE, :DESNOTE, :DESPAYMENT)", array(
                        ':DESCODE' => $this->getdesCode(),
                        ':IDCONTRAC' => $this->getidContract(),
                        ':DESFINED' => trim(str_replace(",", ".",preg_replace('/[R$.]/',"",$this->getdesFined()))),
                        ':DESINTEREST' => trim(str_replace(",", ".",preg_replace('/[R$.]/',"",$this->getdesInterest()))),
                        ':DESPORTIONS' => $this->getdesPortions(),
                        ':DESMONTH' => $this->getdesMonth(),
                        ':DESVALUE' => trim(str_replace(",", ".",preg_replace('/[R$.]/',"",$this->getdesValue()))),
                        ':DESNOTE' => $this->getdesNote(),
                        ':DESPAYMENT' => "Y"
                    ));

                    if ($this->updatePortions()) {
                        if ($this->verifyInsertData()) {
                            $_SESSION['msg'] = 'insert-success';
                        } else {
                            $_SESSION['msg'] = 'insert-error';
                        }
                    } else {
                        $sql->allQuery("DELETE FROM tbreceipt WHERE :IDRECEIPT", array(
                            ':IDRECEIPT' => $_SESSION[Dao::SESSION]
                        ));
                        $_SESSION['error'] = array(
                            'type' => "danger",
                            'ico' => "fa-ban",
                            'title' => "Erro",
                            'msg' => "Não foi possível inserir o registro devido erro no Desconto."
                        );
                        $this->restoreData();
                        header("location: /receipt/create");
                        exit;
                    }
                } catch (\PDOException $e) {
                    $_SESSION['error'] = array(
                        'type' => "danger",
                        'ico' => "fa-ban",
                        'title' => "Erro",
                        'msg' => "Não foi possível inserir o registro.<br>" . $e->getMessage()
                    );
                    $this->restoreData();
                    header("location: /receipt/create");
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
            header("location: /receipt/create");
            exit;
        }
    }

    private function updatePortions()
    {
        try {
            $sql = new Dao();

            if (strstr($this->getdesPortions(), ",")) {
                $portions = explode(",", $this->getdesPortions());

                foreach ($portions as $value) {
                    $sql->allQuery("UPDATE tbportions SET desPayment = :PAYMENT WHERE idPortions = :IDPORTIONS", array(
                        ':PAYMENT' => "Y",
                        ':IDPORTIONS' => $value
                    ));
                }
            } else {
                $sql->allQuery("UPDATE tbportions SET desPayment = :PAYMENT WHERE idPortions = :IDPORTIONS", array(
                    ':PAYMENT' => "Y",
                    ':IDPORTIONS' => $this->getdesPortions()
                ));
            }

            return true;

        } catch (\PDOException $e) {
            return $e->getMessage();
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
            header("location: /receipt/update/" . $this->getidContract());
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

        if (empty(trim($this->getidContract()))) {
            return false;
        }

        if (empty(trim($this->getdesMonth()))) {
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
            $result = $sql->allSelect("SELECT * FROM tbreceipt WHERE idContract = :IDCONTRAC AND desMonth = :DESMONTH", array(
                ':IDCONTRAC' => $this->getidContract(),
                ':DESMONTH' => $this->getdesMonth()
            ));

            if (is_array($result) && count($result) > 0) {
                return true;
            }
        } catch (\PDOException $e) {
            $_SESSION['error'] = array(
                'type' => "danger",
                'ico' => "fa-ban",
                'title' => "Erro",
                'msg' => "Não foi possível verificar se existe Recibo para o período informado no Banco de Dados.<br>" . $e->getMessage()
            );
            $this->restoreData();
            header("location: /receipt/create");
            exit;
        }
        return false;
    }

    private function verifyInsertData()
    {
        try {
            $sql = new Dao();
            $result = $sql->allSelect("SELECT * FROM tbreceipt WHERE desCode = :DESCODE", array(
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
            'idContract' => $this->getidContract(),
            'desFined' => $this->getdesFined(),
            'desInterest' => $this->getdesInterest(),
            'desMonth' => $this->getdesMonth(),
            'desValue' => $this->getdesValue(),
            'desNote' => $this->getdesNote()
        );
        $_SESSION['optRecovered'] = $this->getdesPortions();
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