<?php

namespace App\DTO\Company;

use Symfony\Component\Validator\Constraints as Assert;

class CompanyDTO
{
    public function __construct(
        #[Assert\NotBlank]
        #[Assert\Type('string')]
        public readonly string $name,

        #[Assert\NotBlank]
        #[Assert\Type('string')]
        #[Assert\Length(14)]
        public readonly string $cnpj,

        #[Assert\Type('boolean')]
        public readonly bool $isActive = true,
    ) {
    }
}