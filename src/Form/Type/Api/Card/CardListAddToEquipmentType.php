<?php
/**
 * Created by PhpStorm.
 * User: temerso_test
 * Date: 18.06.2020
 * Time: 13:14
 */

namespace App\Form\Type\Api\Card;


use App\Form\Data\Api\Card\CardAddToEquipmentData;
use App\Form\Data\Api\Card\CardListAddToEquipmentData;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Список карточек(которые нужно найти) для добавления в комплект
 */
class CardListAddToEquipmentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('id', null, [
                'required' => true,
                'documentation' => [
                    'type' => 'integer',
                    'description' => 'Ключ комплекта',
                ],
            ])
            ->add('list', CollectionType::class, [
                'entry_type' => CardItemAddToEquipmentType::class,
                'required' => true,
                'constraints' => [
//                    new Assert\Count([
//                        'min' => 1,
//                        'minMessage' => 'Хотя бы одна карточка',
//                    ]),
                ],
                'allow_add' => true,
                'documentation' => [
                    'description' => 'Список карточек для поиска',
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'method' => 'POST',
            'data_class' => CardListAddToEquipmentData::class
        ));
    }
}