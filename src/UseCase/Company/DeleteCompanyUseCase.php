<?php

namespace App\UseCase\Company;

use App\Repository\CompanyRepository;

class DeleteCompanyUseCase {
    private CompanyRepository $companyRepository;

    public function __construct(CompanyRepository $companyRepository) {
        $this->companyRepository = $companyRepository;
    }

    public function execute(string $id): void {
        $company = $this->companyRepository->getCompany($id);
        $this->companyRepository->deleteCompany($company);
    }
}
