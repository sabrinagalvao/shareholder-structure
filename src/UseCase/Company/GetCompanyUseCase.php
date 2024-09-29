<?php

namespace App\UseCase\Company;

use App\Entity\Company;
use App\Repository\CompanyRepository;

class GetCompanyUseCase {
    private CompanyRepository $companyRepository;

    public function __construct(
        CompanyRepository $companyRepository
    ) {
        $this->companyRepository = $companyRepository;
    }

    public function execute($id): Company {
        return $this->companyRepository->getCompany($id);
    }
}