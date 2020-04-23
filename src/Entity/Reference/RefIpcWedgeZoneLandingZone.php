<?php

namespace App\Entity\Reference;

use Doctrine\ORM\Mapping as ORM;

/**
 * 12)МПК зоны клинев и зоны высадки
 *
 * Проведена,
 * Не проводилась,
 * CRK - трещина
 *
 * @ORM\Entity(repositoryClass="App\Repository\Reference\IpcWedgeZoneLandingZoneRepository")
 */
class RefIpcWedgeZoneLandingZone extends \App\Classes\Reference\ReferenceParent
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $value;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getValue(): ?string
    {
        return $this->value;
    }

    public function setValue(string $value): self
    {
        $this->value = $value;

        return $this;
    }
}
