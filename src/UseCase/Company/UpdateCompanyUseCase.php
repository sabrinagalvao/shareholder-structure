<?php

namespace App\UseCase\Company;

use App\DTO\Company\UpdateCompanyDTO;
use App\Entity\Company;
use App\Repository\CompanyRepository;

class UpdateCompanyUseCase {
    private CompanyRepository $companyRepository;

    public function __construct(
        CompanyRepository $companyRepository
    ) {
        $this->companyRepository = $companyRepository;
    }

    public function execute(string $id, UpdateCompanyDTO $updateCompanyDTO): Company {
        $company = $this->companyRepository->getCompany($id);
        return $this->companyRepository->updateCompany($company, $updateCompanyDTO);
    }
}