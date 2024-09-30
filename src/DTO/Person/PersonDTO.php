<?php

namespace App\DTO\Person;

use App\Validator\CpfValidator;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Context\ExecutionContextInterface;

class PersonDTO
{
    public function __construct(
        #[Assert\NotBlank]
        #[Assert\Type('string')]
        public readonly string $name,

        #[Assert\NotBlank]
        #[Assert\Type('string')]
        #[Assert\Callback([self::class, 'validateCpf'])]
        public string $cpf,

        #[Assert\NotNull]
        #[Assert\Type('array')]
        public array $companies,
    ) {
        $this->cpf = $this->cleanCpf($cpf);
    }

    public static function validateCpf(string $cpf, ExecutionContextInterface $context): void
    {
        $cpfValidator = new CpfValidator();
        if (!$cpfValidator->validate($cpf)) {
            $context->buildViolation('Invalid CPF.')
                ->atPath('cpf')
                ->addViolation();
        }
    }

    private function cleanCpf(string $cpf): string
    {
        return preg_replace('/[^0-9]/', '', $cpf);
    }
}