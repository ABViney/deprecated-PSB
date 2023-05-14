<?php

namespace App\Entity;

use App\Repository\ESRLaborRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ESRLaborRepository::class)]
class ESRLabor
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'esr_laborers')]
    #[ORM\JoinColumn(nullable: false)]
    private ?ESR $esr = null;

    #[ORM\ManyToOne(inversedBy: 'esr_labors')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Employee $employee = null;

    #[ORM\Column]
    private ?float $labor_hours = null;

    public function getId(): ?int
    {
        return $this->id;
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
