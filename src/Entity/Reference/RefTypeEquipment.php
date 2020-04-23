<?php

namespace App\Entity\Reference;

use Doctrine\ORM\Mapping as ORM;

/**
 * 1) тип Оборудования
 *
 * СБТ  (Стальная бурильная труба),
 * БТ (Бурильная труба),
 * ЛБТ  (Легкосплавная бурильная труба),
 * УБТ (Утяжелённая бурильная труба),
 * УБТ-С  (Спиральная УБТ),
 * УБТ-Г  (Гладкая УБТ),
 * УБТ-У  (Укороченная УБТ),
 * УБТН  (Немагнитная УБТ),
 * ТБТ (Толстостенная бурильная труба),
 * ТБТН (Толстостенная бурильная труба немагнитная),
 * Пер. (Переводник М-Н с одной резьбы на другую),
 * Пер. Н-Н  (Переводник привода ниппель-ниппель),
 * Пер. М-М  (Наддолотный переводник муфта-муфта),
 * ВБТ-К (Ведущие бурильные трубы квадратного сечения),
 * ВБТ-Ш  (Ведущие бурильные трубы шестигранного сечения),
 * В наименовании оборудования  (см.73 строку этого листа) нужно выводить только аббревиатуру, без расшифровки. В графе тип оборудования непосредственно в карточке -указывать аббревиатуру + расшифровку
 * @ORM\Entity(repositoryClass="App\Repository\Reference\TypeEquipmentRepository")
 */
class RefTypeEquipment extends \App\Classes\Reference\ReferenceParent
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
