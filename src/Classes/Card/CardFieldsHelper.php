<?php
/**
 * Created by PhpStorm.
 * User: temerso_test
 * Date: 28.04.2020
 * Time: 13:42
 */

namespace App\Classes\Card;


use App\Entity\Card;
use App\Entity\CardFields;
use App\Entity\CardFieldsOption;
use App\Form\Type\CardFieldsType;
use Doctrine\ORM\EntityManagerInterface;
use Sonata\AdminBundle\Form\FormMapper;

class CardFieldsHelper
{
    /**
     * @var EntityManagerInterface
     */
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    /**
     * @param FormMapper $formMapper
     * @param Card $card
     */
    public function addToForm(FormMapper $formMapper, Card $card)
    {
        $cardFieldsFromCard = $card->getCardFields();
        $fieldsFromOption = $this->em->getRepository(CardFieldsOption::class)->findAll();

        $numberField = function (CardFieldsOption $field) {
            $type = \Symfony\Component\Form\Extension\Core\Type\NumberType::class;
            $options = [];

            return [$type, $options];
        };
        $stringField = function (CardFieldsOption $field) {
            $type = \Symfony\Component\Form\Extension\Core\Type\TextType::class;
            $options = [];

            return [$type, $options];
        };
        $listField = function (CardFieldsOption $field) {
            $type = \Symfony\Component\Form\Extension\Core\Type\ChoiceType::class;
            $choice = [];
            $fieldValues = array_map('trim', explode(',', $field->getValue()));

            foreach ($fieldValues as $fieldValue) {
                $choice[$fieldValue] = $fieldValue;
            }

            $options = [
                'choices' => $choice,
            ];

            return [$type, $options];
        };

        // Создаем новый там с дополнительными полями
        $formMapper->tab('fieldsFromOption', ['label' => 'Дополнительные поля']);


        // Добавляем поля которых нет в сущности
        foreach ($fieldsFromOption as $fieldOption) {
            $hasField = false;
            foreach ($cardFieldsFromCard as $cardField) {
                if ($fieldOption->getId() === $cardField->getField()->getId()) {
                    $hasField = true;
                    break;
                }
            }
            if (!$hasField) {
                $cardFieldsFromCard[] = (new CardFields())
                    ->setCard($card)
                    ->setField($fieldOption);
            }
        }

        // Формируем типы полей
        $fieldsType = [];
        foreach ($cardFieldsFromCard as $field) {
            $fieldOption = $fieldsFromOption[$field->getField()->getId()];
            $defaultOptions = ['label' => $fieldOption->getTitle(), 'required' => false];

            if ($fieldOption->getType() === CardFieldsOption::TYPE_FLOAT) {
                list($type, $options) = $numberField($fieldOption);
            } elseif ($fieldOption->getType() === CardFieldsOption::TYPE_LIST) {
                list($type, $options) = $listField($fieldOption);
            } else {
                list($type, $options) = $stringField($fieldOption);
            }

            $fieldsType[] = ['type' => $type, 'options' => array_merge($defaultOptions, $options)];
        }

        // Добавляем в форму
        $formMapper->add('cardFields', \Sonata\AdminBundle\Form\Type\CollectionType::class, [
            'entry_type' => CardFieldsType::class,
            'entry_options' => [
                'fieldsType' => $fieldsType
            ],
            'required' => false,
            'label' => false
        ]);

        $formMapper->end();
    }
}