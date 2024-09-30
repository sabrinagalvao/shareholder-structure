<?php

namespace App\UseCase\Person;

use App\DTO\Person\PersonDTO;
use App\Repository\CompanyRepository;
use App\Repository\PersonRepository;

class CreatePersonUseCase 
{
    private PersonRepository $personRepository;
    private CompanyRepository $companyRepository;

    public function __construct(
        PersonRepository $personRepository,
        CompanyRepository $companyRepository
    ) {
        $this->personRepository = $personRepository;
        $this->companyRepository = $companyRepository;
    }

    public function execute(PersonDTO $personDTO) {
        foreach($personDTO->companies as $company) {
            $companies[] = $this->companyRepository->getCompany($company);
        }
        $personDTO->companies = $companies;
        $person = $this->personRepository->savePerson($personDTO);
        return $person;
    }
}