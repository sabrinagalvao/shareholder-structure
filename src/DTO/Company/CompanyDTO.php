<?php

namespace App\DTO\Company;

use App\Validator\CnpjValidator;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Context\ExecutionContextInterface;

class CompanyDTO
{
    public function __construct(
        #[Assert\NotBlank]
        #[Assert\Type('string')]
        public readonly string $name,

        #[Assert\NotBlank]
        #[Assert\Type('string')]
        #[Assert\Callback([self::class, 'validateCnpj'])]
        public string $cnpj,

        #[Assert\Type('boolean')]
        public readonly bool $isActive = true,
    ) {
        $this->cnpj = $this->cleanCnpj($cnpj);
    }

    public static function validateCnpj(string $cpf, ExecutionContextInterface $context): void
    {
        $cnpjValidator = new CnpjValidator();
        if (!$cnpjValidator->validate($cpf)) {
            $context->buildViolation('Invalid CNPJ.')
                ->atPath('cnpj')
                ->addViolation();
        }
    }

    private function cleanCnpj(string $cnpj): string
    {
        return preg_replace('/[^0-9]/', '', $cnpj);
    }
}