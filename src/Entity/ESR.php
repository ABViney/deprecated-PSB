<?php

namespace App\Entity;

use App\Repository\ESRRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[Assert\Cascade] 
#[ORM\HasLifecycleCallbacks]
#[ORM\Entity(repositoryClass: ESRRepository::class)]
class ESR
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATETIME_IMMUTABLE)]
    private ?\DateTimeInterface $created_at = null; 

    #[ORM\Column(type: Types::DATETIME_IMMUTABLE)]
    private ?\DateTimeInterface $last_modified = null;

    #[ORM\Column(length: 255)]
    private ?string $serial_no = null;

    #[ORM\Column(length: 255)]
    private ?string $model = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $description = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $date = null;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    private ?ESRResult $esr_result = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $problems = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $action_taken = null;

    #[ORM\OneToMany(mappedBy: 'esr', targetEntity: ESRPartUsed::class, cascade: ['persist', 'remove'])]
    private Collection $esr_parts_used;

    #[ORM\OneToMany(mappedBy: 'esr', targetEntity: ESRLabor::class, cascade: ['persist', 'remove'])]
    private Collection $esr_labors;

    #[ORM\ManyToOne(inversedBy: 'signed_ESRs')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Employee $signed_by = null;

    public function __construct()
    {
        $this->esr_parts_used = new ArrayCollection();
        $this->esr_labors = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->created_at;
    }

    #[ORM\PrePersist]
    public function setCreatedAtPersist(): self
    {
        $this->created_at = new \DateTimeImmutable('now', new \DateTimeZone('utc'));

        return $this;
    }

    public function setCreatedAt(\DateTimeInterface $created_at): self
    {
        $this->created_at = $created_at;

        return $this;
    }

    public function getLastModified(): ?\DateTimeInterface
    {
        return $this->last_modified;
    }

    #[ORM\PrePersist]
    #[ORM\PreUpdate]
    public function updateLastModified(): self
    {
        $this->last_modified = new \DateTimeImmutable('now', new \DateTimeZone('utc'));

        return $this;
    }

    public function setLastModified(\DateTimeInterface $last_modified): self
    {
        $this->last_modified = $last_modified;

        return $this;
    }

    public function getSerialNo(): ?string
    {
        return $this->serial_no;
    }

    public function setSerialNo(string $serial_no): self
    {
        $this->serial_no = $serial_no;

        return $this;
    }

    public function getModel(): ?string
    {
        return $this->model;
    }

    public function setModel(string $model): self
    {
        $this->model = $model;

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

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getEsrResult(): ?ESRResult
    {
        return $this->esr_result;
    }

    public function setEsrResult(?ESRResult $esr_result): self
    {
        $this->esr_result = $esr_result;

        return $this;
    }

    public function getProblems(): ?string
    {
        return $this->problems;
    }

    public function setProblems(string $problems): self
    {
        $this->problems = $problems;

        return $this;
    }

    public function getActionTaken(): ?string
    {
        return $this->action_taken;
    }

    public function setActionTaken(string $action_taken): self
    {
        $this->action_taken = $action_taken;

        return $this;
    }

    /**
     * @return Collection<int, ESRPartUsed>
     */
    public function getEsrPartsUsed(): Collection
    {
        return $this->esr_parts_used;
    }

    public function addEsrPartsUsed(ESRPartUsed $esrPartsUsed): self
    {
        if (!$this->esr_parts_used->contains($esrPartsUsed)) {
            $this->esr_parts_used->add($esrPartsUsed);
            $esrPartsUsed->setEsr($this);
        }

        return $this;
    }

    public function removeEsrPartsUsed(ESRPartUsed $esrPartsUsed): self
    {
        if ($this->esr_parts_used->removeElement($esrPartsUsed)) {
            // set the owning side to null (unless already changed)
            if ($esrPartsUsed->getEsr() === $this) {
                $esrPartsUsed->setEsr(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, ESRLabor>
     */
    public function getEsrLabors(): Collection
    {
        return $this->esr_labors;
    }

    public function setEsrLabors(Collection $esrLabors): self
    {
        /** @var ESRLabor */
        foreach ($esrLabors as $esr_labor) {
            $this->addEsrLabor($esr_labor);
        }

        return $this;
    }

    public function addEsrLabor(ESRLabor $esrLabor): self
    {
        if (!$this->esr_labors->contains($esrLabor)) {
            $this->esr_labors->add($esrLabor);
            $esrLabor->setEsr($this);
        }

        return $this;
    }

    public function removeEsrLabor(ESRLabor $esrLabor): self
    {
        if ($this->esr_labors->removeElement($esrLabor)) {
            // set the owning side to null (unless already changed)
            if ($esrLabor->getEsr() === $this) {
                $esrLabor->setEsr(null);
            }
        }

        return $this;
    }

    public function getSignedBy(): ?Employee
    {
        return $this->signed_by;
    }

    public function setSignedBy(?Employee $signed_by): self
    {
        $this->signed_by = $signed_by;

        return $this;
    }
}
