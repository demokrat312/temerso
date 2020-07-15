<?php

namespace App\Entity\Reference;

use Doctrine\ORM\Mapping as ORM;
use Swagger\Annotations as SWG;

/**
 * 5)Тип резьбы
 *
 * З-30 (NC-10),
 * З-38 (NC-13),
 * З-44 (NC-16),
 * З-38 (NC-13),
 * З-65 (NC-23),
 * З-66 (2 3/8 Reg),
 * З-73 (NC-26),
 * З-76 (2 7/8 Reg),
 * З-83      (Z83),
 * З-83 DS  (Z83DS),
 * З-86 (NC-31),
 * З-88 (3 1/2 Reg),
 * З-94 (NC-35),
 * З-101 (3 1/2 FH),
 * З-102 (NC-38 ),
 * З-108 (NC-40),
 * З-117 (4 1/2 Reg),
 * З-118 (NC-44),
 * З-121 (4 1/2 FH),
 * З-122 (NC-46),
 * З-133 (NC-50),
 * З-140 (5 1/2 Reg),
 * З-147 (5 1/2 FH),
 * З-149 (NC-56),
 * З-152 (6 5/8 Reg),
 * З-161,
 * З-163 (NC-61),
 * З-171 (6 5/8 FH),
 * З-177 (7 5/8 Reg),
 * З-185 (NC-70),
 * З-189,
 * З-201 (8 5/8 Reg),
 * З-203 (NC-77),
 *Также для администратора будет доступен функционал по внесению новых значений списка этой характеристики
 *
 * @ORM\Entity(repositoryClass="App\Repository\Reference\TypeThreadRepository")
 *
 *  @SWG\Definition(
 *     definition="RefTypeThread",
 *     description="Тип резьбы",
 * )
 */
class RefTypeThread extends \App\Classes\Reference\ReferenceParent
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

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $description;

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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }
}
