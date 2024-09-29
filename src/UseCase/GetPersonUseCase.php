<?php

namespace App\UseCase;

use App\Entity\Person;
use App\Repository\PersonRepository;

class GetPersonUseCase {
    private PersonRepository $personRepository;

    public function __construct(
        PersonRepository $personRepository
    ) {
        $this->personRepository = $personRepository;
    }

    public function execute($id): Person {
        return $this->personRepository->getPerson($id);
    }
}