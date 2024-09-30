<?php

namespace App\Controller;

use App\DTO\Person\PersonDTO;
use App\DTO\Person\UpdatePersonDTO;
use App\UseCase\Person\CreatePersonUseCase;
use App\UseCase\Person\DeletePersonUseCase;
use App\UseCase\Person\GetPersonUseCase;
use App\UseCase\Person\ListPersonUseCase;
use App\UseCase\Person\UpdatePersonUseCase;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Annotation\Route;

class PersonController extends AbstractController
{
    private ListPersonUseCase $listPersonUseCase;
    private GetPersonUseCase $getPersonUseCase;
    private CreatePersonUseCase $createPersonUseCase;
    private UpdatePersonUseCase $updatePersonUseCase;
    private DeletePersonUseCase $deletePersonUseCase;

    public function __construct(
        ListPersonUseCase $listPersonUseCase,
        GetPersonUseCase $getPersonUseCase,
        CreatePersonUseCase $createPersonUseCase,
        UpdatePersonUseCase $updatePersonUseCase,
        DeletePersonUseCase $deletePersonUseCase,
    ) {
        $this->listPersonUseCase = $listPersonUseCase;
        $this->getPersonUseCase = $getPersonUseCase;
        $this->createPersonUseCase = $createPersonUseCase;
        $this->updatePersonUseCase = $updatePersonUseCase;
        $this->deletePersonUseCase = $deletePersonUseCase;
    }

    #[Route('/person', name: 'list_person', methods: ['GET'])]
    public function index(): JsonResponse
    {
        $persons = $this->listPersonUseCase->execute();
        return $this->json($persons, 200, [], ['groups' => ['person', 'company', 'person_with_companies']]);
    }

    #[Route('/person/{id}', name: 'get_person', methods: ['GET'])]
    public function show(string $id): JsonResponse
    {
        $person = $this->getPersonUseCase->execute($id);
        return $this->json($person, 200, [], ['groups' => ['person', 'company', 'person_with_companies']]);
    }

    #[Route('/person', name: 'create_person', methods: ['POST'])]
    public function create(
        #[MapRequestPayload] PersonDTO $personDTO
    ): JsonResponse
    {
        $person = $this->createPersonUseCase->execute($personDTO);
        return $this->json($person, 201, [], ['groups' => ['person', 'company', 'person_with_companies']]);
    }

    #[Route('/person/{id}', name: 'update_person', methods: ['PATCH'])]
    public function update(
        string $id, 
        #[MapRequestPayload] UpdatePersonDTO $updatePersonDTO
    ): JsonResponse
    {
        $person = $this->updatePersonUseCase->execute($id, $updatePersonDTO);

        return $this->json($person, 200, [], ['groups' => ['person', 'company', 'person_with_companies']]);
    }

    #[Route('/person/{id}', name: 'delete_person', methods: ['DELETE'])]
    public function delete(string $id): JsonResponse
    {
        $this->deletePersonUseCase->execute($id);
        return $this->json(null, 204);
    }
}
