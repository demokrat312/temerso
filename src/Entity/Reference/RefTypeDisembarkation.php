<?php

namespace App\Entity\Reference;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Swagger\Annotations as SWG;

/**
 * 3) Тип высадки
 *
 * EU (Наружная),
 * IU (Внутренняя),
 * IEU  (Комбинированная)
 *
 * @ORM\Entity(repositoryClass="App\Repository\Reference\TypeDisembarkationRepository")
 *
 *  @SWG\Definition(
 *     definition="RefTypeDisembarkation",
 *     description="Тип высадки",
 * )
 */
class RefTypeDisembarkation extends \App\Classes\Reference\ReferenceParent
{
    /**
     * Ключ
     *
     * @var
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups({\App\Classes\ApiParentController::GROUP_API_DEFAULT})
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
