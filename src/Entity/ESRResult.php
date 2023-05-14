<?php

namespace App\Entity;

use App\Repository\ESRResultRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ESRResultRepository::class)]
class ESRResult
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?bool $estimate_required = null;

    #[ORM\Column]
    private ?bool $equipment_repair = null;

    #[ORM\Column]
    private ?bool $pm_pi_ovp_esi = null;

    #[ORM\Column]
    private ?bool $operation_calibration = null;

    #[ORM\Column]
    private ?bool $electrical_safety_test = null;

    #[ORM\Column]
    private ?bool $visual_inspection = null;

    #[ORM\Column(nullable: true)]
    private ?bool $passed = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $test_equipment_serial_no = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function isEstimateRequired(): ?bool
    {
        return $this->estimate_required;
    }

    public function setEstimateRequired(bool $estimate_required): self
    {
        $this->estimate_required = $estimate_required;

        return $this;
    }

    public function isEquipmentRepair(): ?bool
    {
        return $this->equipment_repair;
    }

    public function setEquipmentRepair(bool $equipment_repair): self
    {
        $this->equipment_repair = $equipment_repair;

        return $this;
    }

    public function isPmPiOvpEsi(): ?bool
    {
        return $this->pm_pi_ovp_esi;
    }

    public function setPmPiOvpEsi(bool $pm_pi_ovp_esi): self
    {
        $this->pm_pi_ovp_esi = $pm_pi_ovp_esi;

        return $this;
    }

    public function isOperationCalibration(): ?bool
    {
        return $this->operation_calibration;
    }

    public function setOperationCalibration(bool $operation_calibration): self
    {
        $this->operation_calibration = $operation_calibration;

        return $this;
    }

    public function isElectricalSafetyTest(): ?bool
    {
        return $this->electrical_safety_test;
    }

    public function setElectricalSafetyTest(bool $electrical_safety_test): self
    {
        $this->electrical_safety_test = $electrical_safety_test;

        return $this;
    }

    public function isVisualInspection(): ?bool
    {
        return $this->visual_inspection;
    }

    public function setVisualInspection(bool $visual_inspection): self
    {
        $this->visual_inspection = $visual_inspection;

        return $this;
    }

    public function isPassed(): ?bool
    {
        return $this->passed;
    }

    public function setPassed(?bool $passed): self
    {
        $this->passed = $passed;

        return $this;
    }

    public function getTestEquipmentSerialNo(): ?string
    {
        return $this->test_equipment_serial_no;
    }

    public function setTestEquipmentSerialNo(?string $test_equipment_serial_no): self
    {
        $this->test_equipment_serial_no = $test_equipment_serial_no;

        return $this;
    }
}
