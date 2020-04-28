<?php

namespace App\Admin;


use App\Classes\MainAdmin;
use App\Entity\CardFieldsOption;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

/**
 * Дополнительные поля для карточки
 */
class CardFieldsOptionAdmin extends MainAdmin
{
    /**
     * {@inheritdoc}
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('title', null, ['label' => 'Название'])
            ->add('typeTitle', null, ['label' => 'Тип'])
            ->add('value', null, ['label' => 'Значения']);
    }

    /**
     * {@inheritdoc}
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('title', null, ['label' => 'Название'])
            ->add('type', ChoiceType::class, [
                'label' => 'Тип',
                'choices' => [
                    CardFieldsOption::TYPE_TITLE[CardFieldsOption::TYPE_FLOAT] => CardFieldsOption::TYPE_FLOAT,
                    CardFieldsOption::TYPE_TITLE[CardFieldsOption::TYPE_STRING] => CardFieldsOption::TYPE_STRING,
                    CardFieldsOption::TYPE_TITLE[CardFieldsOption::TYPE_LIST] => CardFieldsOption::TYPE_LIST,
                ],
            ])
            ->add('value', null, ['label' => 'Значения', 'help' => 'Для поля с типом "число" и "строка". 
            Введенной значение будет значением по умолчанию. Для поля с типом "список" введенные значения будут значениями списка (через запятую)'
            ]);


    }
}