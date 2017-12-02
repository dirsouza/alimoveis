<?php

namespace ALImoveis\Models;


class Validate
{
    public static function validateCPF($cpf)
    {
        // Remove máscara
        $cpf = preg_replace('/[^0-9]/is', '', $cpf);

        // Verifica se todos os dígitos foram informados
        if (strlen($cpf) != 11) {
            return false;
        }

        // Verifica se os dígitos são sequenciais
        if (preg_match('/(\d)\1{10}/', $cpf)) {
            return false;
        }

        // Faz o cálculo para validar o CPF
        for ($t = 9; $t < 11; $t++) {
            for ($d = 0, $c = 0; $c < $t; $c++) {
                $d += $cpf{$c} * (($t + 1) - $c);
            }
            $d = ((10 * $d) % 11) % 10;
            if ($cpf{$c} != $d) {
                return false;
            }
        }
        return true;
    }
}