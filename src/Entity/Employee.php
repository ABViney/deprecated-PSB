<?php

namespace App\Entity;

use App\Repository\EmployeeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EmployeeRepository::class)]
class Employee
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $first_name = null;

    #[ORM\Column(length: 255)]
    private ?string $last_name = null;

    #[ORM\OneToMany(mappedBy: 'employee', targetEntity: ESRLabor::class)]
    private Collection $esr_labors;

    public function __construct()
    {
        $this->esr_labors = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFirstName(): ?string
    {
        return $this->first_name;
    }

    public function setFirstName(string $first_name): self
    {
        $this->first_name = $first_name;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->last_name;
    }

    public function setLastName(string $last_name): self
    {
        $this->last_name = $last_name;

        return $this;
    }

    /**
     * @return Collection<int, ESRLabor>
     */
    public function getEsrLabors(): Collection
    {
        return $this->esr_labors;
    }

    public function addEsrLabor(ESRLabor $esrLabor): self
    {
        if (!$this->esr_labors->contains($esrLabor)) {
            $this->esr_labors->add($esrLabor);
            $esrLabor->setEmployee($this);
        }

        return $this;
    }

    public function removeEsrLabor(ESRLabor $esrLabor): self
    {
        if ($this->esr_labors->removeElement($esrLabor)) {
            // set the owning side to null (unless already changed)
            if ($esrLabor->getEmployee() === $this) {
                $esrLabor->setEmployee(null);
            }
        }

        return $this;
    }
}
