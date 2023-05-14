<?php

namespace App\Entity;

use App\Repository\ESRPartUsedRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ESRPartUsedRepository::class)]
class ESRPartUsed
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'esr_parts_used')]
    #[ORM\JoinColumn(nullable: false)]
    private ?ESR $esr = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?ESRPart $esr_part = null;

    #[ORM\Column]
    private ?int $quantity = null;

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

    public function getEsrPart(): ?ESRPart
    {
        return $this->esr_part;
    }

    public function setEsrPart(?ESRPart $esr_part): self
    {
        $this->esr_part = $esr_part;

        return $this;
    }

    public function getQuantity(): ?int
    {
        return $this->quantity;
    }

    public function setQuantity(int $quantity): self
    {
        $this->quantity = $quantity;

        return $this;
    }
}
