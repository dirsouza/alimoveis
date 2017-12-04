<?php

namespace ALImoveis\Dao;


class Dao
{
    const HOSTNAME  = "localhost";
    const USERNAME  = "root";
    const PASSWORD  = "root";
    const DBNAME    = "dbalimoveis";

    private $conn;

    // Conexão com o Banco de Dados
    public function __construct()
    {
        $this->conn = new \PDO("mysql:dbname=" . Dao::DBNAME . ";host=" . Dao::HOSTNAME, Dao::USERNAME, Dao::PASSWORD);
        $this->conn->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
    }

    // Seta os Parâmentros do array e envia para bindParam
    private function setParams($statement, $parameters = array())
    {
        foreach ($parameters as $key => $value){
            $this->bindParam($statement, $key, $value);
        }
    }

    // Prepara os parâmentros setados para serem executados
    private function bindParam($statement, $key, $value)
    {
        $statement->bindParam($key, $value);
    }

    // Realiza a inserção dos dados
    public function allQuery($rawQuery, $params = array())
    {
        try {
            $this->conn->beginTransaction();
            $stmt = $this->conn->prepare($rawQuery);
            $this->setParams($stmt, $params);
            $stmt->execute();
            $this->conn->commit();
        } catch (\PDOException $e) {
            $this->conn->rollBack();
            throw new \PDOException($e->getMessage());
        }
    }

    // Realiza a consulta ou inserção retornando um array
    public function allSelect($rawQuery, $params = array()):array
    {
        try {
            $this->conn->beginTransaction();
            $stmt = $this->conn->prepare($rawQuery);
            $this->setParams($stmt, $params);
            $stmt->execute();
            $this->conn->commit();
        } catch (\PDOException $e) {
            $this->conn->rollBack();
            throw new \PDOException($e->getMessage());
        }
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
}