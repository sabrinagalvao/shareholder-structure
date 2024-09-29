<?php

namespace App\UseCase\Company;

use App\DTO\Company\CompanyDTO;
use App\Repository\CompanyRepository;

class CreateCompanyUseCase {
    private CompanyRepository $companyRepository;

    public function __construct(
        CompanyRepository $companyRepository
    ) {
        $this->companyRepository = $companyRepository;
    }

    public function execute(CompanyDTO $companyDTO) {
        $company = $this->companyRepository->saveCompany($companyDTO);
        return $company;
    }
}