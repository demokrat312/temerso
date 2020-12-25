<?php

namespace App\Entity\Reference;

use Doctrine\ORM\Mapping as ORM;
use Swagger\Annotations as SWG;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * 7)Внутреннее покрытие
 *
 * TC2000,
 * Без покрытия,
 * Другое (введите значение)
 *Также для администратора будет доступен функционал по внесению новых значений списка этой характеристики
 *
 * @ORM\Entity(repositoryClass="App\Repository\Reference\InnerCoatingRepository")
 *
 * Покрытие резьбы @SWG\Definition(
 *     definition="RefInnerCoating",
 *     description="Внутреннее покрытие",
 * )
 */
class RefInnerCoating extends \App\Classes\Reference\ReferenceParent
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups({\App\Classes\ApiParentController::GROUP_API_DEFAULT})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({\App\Classes\ApiParentController::GROUP_API_DEFAULT})
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
