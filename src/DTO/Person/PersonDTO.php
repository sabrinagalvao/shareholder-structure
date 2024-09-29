<?php

namespace App\DTO\Person;

use Symfony\Component\Validator\Constraints as Assert;

class PersonDTO
{
    public function __construct(
        #[Assert\NotBlank]
        #[Assert\Type('string')]
        public readonly string $name,

        #[Assert\NotBlank]
        #[Assert\Type('string')]
        #[Assert\Length(11)]
        public readonly string $cpf,
    ) {
    }
}