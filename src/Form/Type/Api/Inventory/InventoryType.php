<?php
/**
 * Created by PhpStorm.
 * User: temerso_test
 * Date: 2020-07-23
 * Time: 15:24
 */

namespace App\Form\Type\Api\Inventory;


use App\Form\Data\Api\Inventory\InventoryData;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;

class InventoryType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('id', null, [
                'required' => true,
                'documentation' => [
                    'type' => 'integer',
                    'description' => 'Ключ инвентаризации',
                ],
            ])
            ->add('overList', CollectionType::class, [
                'required' => true,
                'entry_type' => InventoryOverType::class,
                'documentation' => [
//                    'type' => InventoryOverType::class,
                    'description' => 'Излишек, список',
                ],
                'allow_add' => true,
                'constraints' => [
                    new Assert\Count([
                        'min' => 1,
                        'minMessage' => 'Хотя бы одна запись',
                    ])
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'csrf_protection' => false,
//            'allow_extra_fields' => true,
            'method' => 'POST',
            'compound' => true,
            'data_class' => InventoryData::class
        ));
    }
}