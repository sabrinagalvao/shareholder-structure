<?php

namespace App\UseCase\Person;

use App\DTO\Person\UpdatePersonDTO;
use App\Entity\Person;
use App\Repository\CompanyRepository;
use App\Repository\PersonRepository;

class UpdatePersonUseCase {
    private PersonRepository $personRepository;
    private CompanyRepository $companyRepository;

    public function __construct(
        PersonRepository $personRepository,
        CompanyRepository $companyRepository
    ) {
        $this->personRepository = $personRepository;
        $this->companyRepository = $companyRepository;
    }

    public function execute(string $id, UpdatePersonDTO $updatePersonDTO): Person {
        foreach($updatePersonDTO->companiesToAdd as $company) {
            $companies[] = $this->companyRepository->getCompany($company);
        }
        $updatePersonDTO->companiesToAdd = $companies;
        $person = $this->personRepository->getPerson($id);
        return $this->personRepository->updatePerson($person, $updatePersonDTO);
    }
}