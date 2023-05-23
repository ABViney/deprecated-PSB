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

    #[ORM\OneToMany(mappedBy: 'signed_by', targetEntity: ESR::class)]
    private Collection $signed_ESRs;

    #[ORM\OneToMany(mappedBy: 'assigned_to', targetEntity: Account::class)]
    private Collection $account;

    public function __construct()
    {
        $this->esr_labors = new ArrayCollection();
        $this->signed_ESRs = new ArrayCollection();
        $this->account = new ArrayCollection();
    }

    public function __toString()
    {
        return $this->first_name.' '.$this->last_name;
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

    /**
     * @return Collection<int, ESR>
     */
    public function getSignedESRs(): Collection
    {
        return $this->signed_ESRs;
    }

    public function addSignedESR(ESR $signedESR): self
    {
        if (!$this->signed_ESRs->contains($signedESR)) {
            $this->signed_ESRs->add($signedESR);
            $signedESR->setSignedBy($this);
        }

        return $this;
    }

    public function removeSignedESR(ESR $signedESR): self
    {
        if ($this->signed_ESRs->removeElement($signedESR)) {
            // set the owning side to null (unless already changed)
            if ($signedESR->getSignedBy() === $this) {
                $signedESR->setSignedBy(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Account>
     */
    public function getAccounts(): Collection
    {
        return $this->account;
    }

    public function addAccount(Account $account): self
    {
        if (!$this->account->contains($account)) {
            $this->account->add($account);
            $account->setAssignedTo($this);
        }

        return $this;
    }

    public function removeAccount(Account $account): self
    {
        if ($this->account->removeElement($account)) {
            // set the owning side to null (unless already changed)
            if ($account->getAssignedTo() === $this) {
                $account->setAssignedTo(null);
            }
        }

        return $this;
    }
}
