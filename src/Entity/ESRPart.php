<?php

namespace App\Entity;

use App\Repository\ESRPartRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: ESRPartRepository::class)]
class ESRPart
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $part_no = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $description = null;

    #[Assert\GreaterThan(value: 0)]
    #[ORM\Column]
    private ?int $price = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPartNo(): ?string
    {
        return $this->part_no;
    }

    public function setPartNo(string $part_no): self
    {
        $this->part_no = $part_no;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getPrice(): ?int
    {
        return $this->price;
    }

    public function setPrice(int $price): self
    {
        $this->price = $price;

        return $this;
    }
}
