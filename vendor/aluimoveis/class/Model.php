<?php

namespace ALUImoveis;


class Model
{
    private $values = [];

    // Recebe os parâmentros enviados por getter e setter
    public function __call($name, $args)
    {
        $method = substr($name, 0, 3);
        $fieldName = substr($name, 3, strlen($name));

        switch ($method){
            case "get":
                return $this->values[$fieldName];
            case "set":
                $this->values[$fieldName] = $args[0];
                break;
        }
    }

    // Armazena os dados enviados
    public function setData($data = array())
    {
        foreach ($data as $key => $value) {
            $this->{"set" . $key}($value);
        }
    }

    // Retorna os dados armazenados
    public function getValues()
    {
        return $this->values;
    }
}