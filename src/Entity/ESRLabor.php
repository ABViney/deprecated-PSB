<?php

namespace App\Entity;

use App\Repository\ESRLaborRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: ESRLaborRepository::class)]
class ESRLabor
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'esr_labors', targetEntity: ESR::class)]
    #[ORM\JoinColumn(nullable: false)]
    private ?ESR $esr = null;

    #[Assert\NotBlank]
    #[ORM\ManyToOne(inversedBy: 'esr_labors', targetEntity: Employee::class)]
    #[ORM\JoinColumn(nullable: false)]
    private ?Employee $employee = null;

    #[ORM\Column]
    private ?float $labor_hours = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function __toString()
    {
        /** @see App\Entity\ESRPartUsed::__toString */
        return '';
    }

    public function getEsr(): ?ESR
    {
        return $this->esr;
    }

    public function setEsr(?ESR $esr): self
    {
        $this->esr = $esr;

        return $this;
    }

    public function getEmployee(): ?Employee
    {
        return $this->employee;
    }

    public function setEmployee(?Employee $employee): self
    {
        $this->employee = $employee;

        return $this;
    }

    public function getLaborHours(): ?float
    {
        return $this->labor_hours;
    }

    public function setLaborHours(float $labor_hours): self
    {
        $this->labor_hours = $labor_hours;

        return $this;
    }
}
