<?php

namespace App\Entity;

use App\Repository\ESRPartUsedRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

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

    #[ORM\ManyToOne(cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?ESRPart $esr_part = null;

    #[Assert\GreaterThan(0)]
    #[ORM\Column]
    private ?int $quantity = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function __toString()
    {
        // NOTE Either EasyAdmin's CollectionField or Symfony's CollectionType
        // is trying to parse associated entities to string. By default, this evaluates to
        // this class's fqcn with an appended #%id%. Outside the embedded form, the user
        // cannot modify ESRPartUsed, so this information should be vacant.
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
