<?php

namespace App\UseCase\Company;

use App\Repository\CompanyRepository;

class ListCompanyUseCase {
    private CompanyRepository $companyRepository;

    public function __construct(
        CompanyRepository $companyRepository
    ) {
        $this->companyRepository = $companyRepository;
    }

    public function execute(): array {
        return $this->companyRepository->listCompany();
    }
}