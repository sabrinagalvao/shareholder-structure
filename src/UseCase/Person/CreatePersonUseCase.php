<?php

namespace App\UseCase\Person;

use App\DTO\Person\PersonDTO;
use App\Repository\PersonRepository;

class CreatePersonUseCase {
    private PersonRepository $personRepository;

    public function __construct(
        PersonRepository $personRepository
    ) {
        $this->personRepository = $personRepository;
    }

    public function execute(PersonDTO $personDTO) {
        $person = $this->personRepository->savePerson($personDTO);
        return $person;
    }
}