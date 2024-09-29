<?php

namespace App\Controller;

use App\DTO\Company\CompanyDTO;
use App\DTO\Company\UpdateCompanyDTO;
use App\UseCase\Company\CreateCompanyUseCase;
use App\UseCase\Company\DeleteCompanyUseCase;
use App\UseCase\Company\GetCompanyUseCase;
use App\UseCase\Company\ListCompanyUseCase;
use App\UseCase\Company\UpdateCompanyUseCase;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Annotation\Route;

class CompanyController extends AbstractController
{
    private ListCompanyUseCase $listCompanyUseCase;
    private GetCompanyUseCase $getCompanyUseCase;
    private CreateCompanyUseCase $createCompanyUseCase;
    private UpdateCompanyUseCase $updateCompanyUseCase;
    private DeleteCompanyUseCase $deleteCompanyUseCase;

    public function __construct(
        ListCompanyUseCase $listCompanyUseCase,
        GetCompanyUseCase $getCompanyUseCase,
        CreateCompanyUseCase $createCompanyUseCase,
        UpdateCompanyUseCase $updateCompanyUseCase,
        DeleteCompanyUseCase $deleteCompanyUseCase
    ) {
        $this->listCompanyUseCase = $listCompanyUseCase;
        $this->getCompanyUseCase = $getCompanyUseCase;
        $this->createCompanyUseCase = $createCompanyUseCase;
        $this->updateCompanyUseCase = $updateCompanyUseCase;
        $this->deleteCompanyUseCase = $deleteCompanyUseCase;
    }

    #[Route('/company', name: 'list_company', methods: ['GET'])]
    public function index(): JsonResponse
    {
        $companies = $this->listCompanyUseCase->execute();

        return $this->json(['companies' => $companies]);
    }

    #[Route('/company/{id}', name: 'get_company', methods: ['GET'])]
    public function show(string $id): JsonResponse
    {
        $company = $this->getCompanyUseCase->execute($id);

        return $this->json(['company' => $company]);
    }

    #[Route('/company', name: 'create_company', methods: ['POST'])]
    public function create(
        #[MapRequestPayload] CompanyDTO $companyDTO
    ): JsonResponse
    {
        $company = $this->createCompanyUseCase->execute($companyDTO);

        return $this->json(['company' => $company], 201);
    }

    #[Route('/company/{id}', name: 'update_company', methods: ['PATCH'])]
    public function update(
        string $id, 
        #[MapRequestPayload] UpdateCompanyDTO $updateCompanyDTO
    ): JsonResponse
    {
        $company = $this->updateCompanyUseCase->execute($id, $updateCompanyDTO);

        return $this->json(['company' => $company]);
    }

    #[Route('/company/{id}', name: 'delete_company', methods: ['DELETE'])]
    public function delete(string $id): JsonResponse
    {
        $this->deleteCompanyUseCase->execute($id);
        return $this->json(null, 204);
    }
}
