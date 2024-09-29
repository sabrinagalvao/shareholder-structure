<?php

namespace App\UseCase;

use App\Repository\PersonRepository;

class DeletePersonUseCase {
    private PersonRepository $personRepository;

    public function __construct(PersonRepository $personRepository) {
        $this->personRepository = $personRepository;
    }

    public function execute(string $id): void {
        $person = $this->personRepository->getPerson($id);
        $this->personRepository->deletePerson($person);
    }
}
