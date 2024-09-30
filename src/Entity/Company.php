<?php

namespace App\Entity;

use App\Repository\CompanyRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Types\UuidType;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Uid\Uuid;

#[ORM\Entity(repositoryClass: CompanyRepository::class)]
class Company
{
    #[ORM\Id]
    #[ORM\Column(type: UuidType::NAME, unique: true)]
    #[ORM\GeneratedValue(strategy: 'CUSTOM')]
    #[ORM\CustomIdGenerator(class: 'doctrine.uuid_generator')]
    #[Groups(['company'])]
    private ?Uuid $id = null;

    #[ORM\Column(length: 14)]
    #[Groups(['company'])]
    private ?string $cnpj = null;

    #[ORM\Column(length: 255)]
    #[Groups(['company'])]
    private ?string $name = null;
    
    #[ORM\Column]
    #[Groups(['company'])]
    private ?bool $isActive = null;

    /**
     * @var Collection<int, Person>
     */
    #[ORM\ManyToMany(targetEntity: Person::class, mappedBy: 'companies')]
    #[Groups(['company_with_shareholders'])]
    private Collection $shareholders;

    public function __construct()
    {
        $this->shareholders = new ArrayCollection();
    }

    public function getId(): ?Uuid
    {
        return $this->id;
    }

    public function getCnpj(): ?string
    {
        return $this->cnpj;
    }

    public function setCnpj(string $cnpj): static
    {
        $this->cnpj = $cnpj;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function isActive(): ?bool
    {
        return $this->isActive;
    }

    public function setActive(bool $isActive): static
    {
        $this->isActive = $isActive;

        return $this;
    }

    /**
     * @return Collection<int, Person>
     */
    public function getShareholders(): Collection
    {
        return $this->shareholders;
    }

    public function addShareholder(Person $shareholder): static
    {
        if (!$this->shareholders->contains($shareholder)) {
            $this->shareholders->add($shareholder);
        }

        return $this;
    }

    public function removeShareholder(Person $shareholder): static
    {
        if ($this->shareholders->removeElement($shareholder)) {
            $shareholder->removeCompany($this);
        }

        return $this;
    }
}
