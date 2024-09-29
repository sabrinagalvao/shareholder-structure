<?php

namespace App\UseCase\Person;

use App\DTO\Person\UpdatePersonDTO;
use App\Entity\Person;
use App\Repository\PersonRepository;

class UpdatePersonUseCase {
    private PersonRepository $personRepository;

    public function __construct(
        PersonRepository $personRepository
    ) {
        $this->personRepository = $personRepository;
    }

    public function execute(string $id, UpdatePersonDTO $updatePersonDTO): Person {
        $person = $this->personRepository->getPerson($id);
        return $this->personRepository->updatePerson($person, $updatePersonDTO);
    }
}