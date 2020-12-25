<?php

namespace App\Entity\Reference;

use Doctrine\ORM\Mapping as ORM;
use Swagger\Annotations as SWG;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * 8)Хардбендинг (ниппель)
 *
 * Интерпро VP-58,
 * Castolin OTW-12Ti,
 * TCS Titanium,
 * Duraband NC,
 * Arnco 350XT,
 * BoTn 3000,
 * Без наплавок,
 * Другое (введите значение)
 *Также для администратора будет доступен функционал по внесению новых значений списка этой характеристики
 *
 * @ORM\Entity(repositoryClass="App\Repository\Reference\HardbandingNippleRepository")
 *
 *  @SWG\Definition(
 *     definition="RefHardbandingNipple",
 *     description="Хардбендинг (ниппель)",
 * )
 */
class RefHardbandingNipple extends \App\Classes\Reference\ReferenceParent
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
