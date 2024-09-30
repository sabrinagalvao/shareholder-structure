<?php

namespace App\DTO\Person;

use Symfony\Component\Validator\Constraints as Assert;

class UpdatePersonDTO
{
    public function __construct(
        #[Assert\NotBlank]
        #[Assert\Type('string')]
        public readonly string $name,

        #[Assert\NotNull]
        #[Assert\Type('array')]
        public array $companiesToAdd,
    ) {
    }
}