<?php

namespace App\Validator;

class CnpjValidator
{
    public function validate(string $rawCnpj): bool
    {
        $cnpj = preg_replace('/[^0-9]/', '', $rawCnpj);

        if (strlen($cnpj) != 14) {
            return false;
        }

        if (preg_match('/^(\d)\1{13}$/', $cnpj)) {
            return false;
        }

        $soma1 = 0;
        $soma2 = 0;
        $peso1 = 5;
        $peso2 = 6;

        for ($i = 0; $i < 12; $i++) {
            $soma1 += $cnpj[$i] * $peso1;
            $soma2 += $cnpj[$i] * $peso2;
            $peso1 = ($peso1 == 2) ? 9 : $peso1 - 1;
            $peso2 = ($peso2 == 2) ? 9 : $peso2 - 1;
        }

        $digito1 = ($soma1 % 11 < 2) ? 0 : 11 - ($soma1 % 11);
        $soma2 += $digito1 * 2;
        $digito2 = ($soma2 % 11 < 2) ? 0 : 11 - ($soma2 % 11);

        return $cnpj[12] == $digito1 && $cnpj[13] == $digito2;
    }
}