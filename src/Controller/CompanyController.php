<?php

namespace App\Controller;

use App\DTO\Company\CompanyDTO;
use App\DTO\Company\UpdateCompanyDTO;
use App\UseCase\Company\CreateCompanyUseCase;
use App\UseCase\Company\DeleteCompanyUseCase;
use App\UseCase\Company\GetCompanyUseCase;
use App\UseCase\Company\ListCompanyUseCase;
use App\UseCase\Company\RemoveShareholdersFromCompanyUseCase;
use App\UseCase\Company\UpdateCompanyUseCase;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

class CompanyController extends AbstractController
{
    private ListCompanyUseCase $listCompanyUseCase;
    private GetCompanyUseCase $getCompanyUseCase;
    private CreateCompanyUseCase $createCompanyUseCase;
    private UpdateCompanyUseCase $updateCompanyUseCase;
    private DeleteCompanyUseCase $deleteCompanyUseCase;
    private RemoveShareholdersFromCompanyUseCase $removeShareholdersFromCompanyUseCase;

    public function __construct(
        ListCompanyUseCase $listCompanyUseCase,
        GetCompanyUseCase $getCompanyUseCase,
        CreateCompanyUseCase $createCompanyUseCase,
        UpdateCompanyUseCase $updateCompanyUseCase,
        DeleteCompanyUseCase $deleteCompanyUseCase,
        RemoveShareholdersFromCompanyUseCase $removeShareholdersFromCompanyUseCase
    ) {
        $this->listCompanyUseCase = $listCompanyUseCase;
        $this->getCompanyUseCase = $getCompanyUseCase;
        $this->createCompanyUseCase = $createCompanyUseCase;
        $this->updateCompanyUseCase = $updateCompanyUseCase;
        $this->deleteCompanyUseCase = $deleteCompanyUseCase;
        $this->removeShareholdersFromCompanyUseCase = $removeShareholdersFromCompanyUseCase;
    }

    #[Route('/company', name: 'list_company', methods: ['GET'])]
    public function index(): JsonResponse
    {
        $companies = $this->listCompanyUseCase->execute();
        return $this->json($companies, 200, [], ['groups' => ['company', 'person', 'company_with_shareholders']]);
    }

    #[Route('/company/{id}', name: 'get_company', methods: ['GET'])]
    public function show(string $id): JsonResponse
    {
        $company = $this->getCompanyUseCase->execute($id);
        return $this->json($company, 200, [], ['groups' => ['company', 'person', 'company_with_shareholders']]);
    }

    #[Route('/company', name: 'create_company', methods: ['POST'])]
    public function create(
        #[MapRequestPayload] CompanyDTO $companyDTO
    ): JsonResponse
    {
        $company = $this->createCompanyUseCase->execute($companyDTO);

        return $this->json($company, 201, [], ['groups' => ['company', 'person', 'company_with_shareholders']]);
    }

    #[Route('/company/{id}', name: 'update_company', methods: ['PATCH'])]
    public function update(
        string $id, 
        #[MapRequestPayload] UpdateCompanyDTO $updateCompanyDTO
    ): JsonResponse
    {
        $company = $this->updateCompanyUseCase->execute($id, $updateCompanyDTO);

        return $this->json($company, 200, [], ['groups' => ['company', 'person', 'company_with_shareholders']]);
    }

    #[Route('/company/{id}', name: 'delete_company', methods: ['DELETE'])]
    public function delete(string $id): JsonResponse
    {
        $this->deleteCompanyUseCase->execute($id);
        return $this->json(null, 204);
    }

    #[Route('/removeShareholders/{companyId}', name: 'remove_shareholder_from_company', methods: ['POST'])]
    public function removeShareholdersFromCompany(
        string $companyId,
        Request $request
    ): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        $company = $this->removeShareholdersFromCompanyUseCase->execute($companyId, $data['shareholders']);
        return $this->json($company, 200, [], ['groups' => ['company', 'person', 'company_with_shareholders']]);
    }
}
