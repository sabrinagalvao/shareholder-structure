<?php

namespace App\Repository;

use App\DTO\Person\PersonDTO;
use App\DTO\Person\UpdatePersonDTO;
use App\Entity\Person;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * @extends ServiceEntityRepository<Person>
 */
class PersonRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Person::class);
    }

    public function savePerson(PersonDTO $personDTO): Person {
        $person = new Person();
        $person->setName($personDTO->name);
        $person->setCpf($personDTO->cpf);
        foreach($personDTO->companies as $company) {
            $person->addCompany($company);
        }

        $entityManager = $this->getEntityManager();
        $entityManager->persist($person);
        $entityManager->flush();

        return $person;
    }

    public function getPerson($id): Person {
        $entityManager = $this->getEntityManager();
        $person = $entityManager->getRepository(Person::class)->find($id);
        if(!$person) throw new NotFoundHttpException("Person not found!");
        return $person;

    }

    public function updatePerson(Person $person, UpdatePersonDTO $updatePersonDTO): Person {
        $entityManager = $this->getEntityManager();

        if ($updatePersonDTO->name !== null) {
            $person->setName($updatePersonDTO->name);
        }

        if ($updatePersonDTO->companiesToAdd !== null) {
            foreach($updatePersonDTO->companiesToAdd as $company) {
                $person->addCompany($company);
            }
        }

        $entityManager->flush();
        return $person;
    }

    public function listPerson() {
        return $this->findAll();
    }

    public function deletePerson(Person $person): void {
        $entityManager = $this->getEntityManager();
        $entityManager->remove($person);
        $entityManager->flush();
    }
}
