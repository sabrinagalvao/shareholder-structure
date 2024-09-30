<?php

namespace App\Repository;

use App\DTO\Company\CompanyDTO;
use App\DTO\Company\UpdateCompanyDTO;
use App\Entity\Company;
use App\Entity\Person;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * @extends ServiceEntityRepository<Company>
 */
class CompanyRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Company::class);
    }

    public function saveCompany(CompanyDTO $companyDTO): Company {
        $company = new Company();
        $company->setName($companyDTO->name);
        $company->setCnpj($companyDTO->cnpj);
        $company->setActive($companyDTO->isActive);

        $entityManager = $this->getEntityManager();
        $entityManager->persist($company);
        $entityManager->flush();

        return $company;
    }

    public function getCompany($id): Company {
        $entityManager = $this->getEntityManager();
        $company = $entityManager->getRepository(Company::class)->find($id);
        if(!$company) throw new NotFoundHttpException("Company not found!");
        return $company;
    }

    public function updateCompany(Company $company, UpdateCompanyDTO $updateCompanyDTO): Company {
        $entityManager = $this->getEntityManager();

        if ($updateCompanyDTO->name !== null) {
            $company->setName($updateCompanyDTO->name);
        }
        if ($updateCompanyDTO->isActive !== null) {
            $company->setActive($updateCompanyDTO->isActive);
        }
        $entityManager->flush();
        
        return $company;
    }

    public function listCompany() {
        return $this->findAll();
    }

    public function deleteCompany(Company $company): void {
        $entityManager = $this->getEntityManager();
        $entityManager->remove($company);
        $entityManager->flush();
    }

    public function removeShareholders(Company $company, array $shareholders): Company {
        $entityManager = $this->getEntityManager();
        foreach($shareholders as $shareholder) {
            $company->removeShareholder($shareholder);
        }
        $entityManager->flush();
        return $company;
    }
}
