<?php

namespace App\DTO;

use Symfony\Component\Validator\Constraints as Assert;

class UpdatePersonDTO
{
    public function __construct(
        #[Assert\NotBlank]
        #[Assert\Type('string')]
        public readonly string $name,
    ) {
    }
}