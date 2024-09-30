<?php

namespace App\Validator;

class CpfValidator
{
    private const FACTOR_FIRST_DIGIT = 10;
    private const FACTOR_SECOND_DIGIT = 11;

    public function validate(string $rawCpf): bool
    {
        if (empty($rawCpf)) {
            return false;
        }

        $cpf = $this->removeNonDigits($rawCpf);

        if (!$this->isValidLength($cpf) || $this->allDigitsEqual($cpf)) {
            return false;
        }

        $firstDigit = $this->calculateDigit($cpf, self::FACTOR_FIRST_DIGIT);
        $secondDigit = $this->calculateDigit($cpf, self::FACTOR_SECOND_DIGIT);

        return $this->extractDigit($cpf) === "{$firstDigit}{$secondDigit}";
    }

    private function removeNonDigits(string $cpf): string
    {
        return preg_replace('/\D/', '', $cpf);
    }

    private function isValidLength(string $cpf): bool
    {
        return strlen($cpf) === 11;
    }

    private function allDigitsEqual(string $cpf): bool
    {
        $firstDigit = $cpf[0];
        return preg_match('/^(' . preg_quote($firstDigit, '/') . ')\1{10}$/', $cpf) === 1;
    }

    private function calculateDigit(string $cpf, int $factor): int
    {
        $total = 0;

        foreach (str_split($cpf) as $digit) {
			if ($factor > 1) $total += $digit * $factor--;
		}
        
        $remainder = $total % 11;
        return ($remainder < 2) ? 0 : 11 - $remainder;
    }

    private function extractDigit(string $cpf): string
    {
        return substr($cpf, 9, 2);
    }
}
