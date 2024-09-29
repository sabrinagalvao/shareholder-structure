<?php

namespace App\UseCase\Person;

use App\Repository\PersonRepository;

class ListPersonUseCase {
    private PersonRepository $personRepository;

    public function __construct(
        PersonRepository $personRepository
    ) {
        $this->personRepository = $personRepository;
    }

    public function execute(): array {
        return $this->personRepository->listPerson();
    }
}