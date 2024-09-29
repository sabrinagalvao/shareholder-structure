<?php

namespace App\DTO\Company;

use phpDocumentor\Reflection\Types\Boolean;
use Symfony\Component\Validator\Constraints as Assert;

class UpdateCompanyDTO
{
    public function __construct(
        #[Assert\NotBlank]
        #[Assert\Type('string')]
        public readonly string $name,

        #[Assert\Type('bool')]
        public readonly ?bool $isActive
    ) {
    }
}