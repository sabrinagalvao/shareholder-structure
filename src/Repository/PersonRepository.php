<?php

namespace App\Repository;

use App\DTO\PersonDTO;
use App\DTO\UpdatePersonDTO;
use App\Entity\Person;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

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

        $entityManager = $this->getEntityManager();
        $entityManager->persist($person);
        $entityManager->flush();

        return $person;
    }

    public function getPerson($id): Person {
        $entityManager = $this->getEntityManager();

        return $entityManager->getRepository(Person::class)->find($id);
    }

    public function updatePerson(Person $person, UpdatePersonDTO $updatePersonDTO): Person {
        $entityManager = $this->getEntityManager();
        $person->setName($updatePersonDTO->name);
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
