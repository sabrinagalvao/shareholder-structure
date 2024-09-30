<?php

namespace App\UseCase\Company;

use App\Entity\Company;
use App\Repository\CompanyRepository;
use App\Repository\PersonRepository;

class RemoveShareholdersFromCompanyUseCase {
    private CompanyRepository $companyRepository;
    private PersonRepository $personRepository;

    public function __construct(
        CompanyRepository $companyRepository,
        PersonRepository $personRepository
    ) {
        $this->companyRepository = $companyRepository;
        $this->personRepository = $personRepository;
    }

    public function execute(string $companyId, array $shareholdersIds): Company {
        $company = $this->companyRepository->getCompany($companyId);
        foreach($shareholdersIds as $shareholder) {
            $shareholders[] = $this->personRepository->getPerson($shareholder);
        }
        $company = $this->companyRepository->removeShareholders($company, $shareholders);
        return $company;
    }
}