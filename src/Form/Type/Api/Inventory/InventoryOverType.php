<?php
/**
 * Created by PhpStorm.
 * User: temerso_test
 * Date: 2020-07-23
 * Time: 15:27
 */

namespace App\Form\Type\Api\Inventory;


use App\Entity\InventoryOver;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class InventoryOverType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('pipeSerialNumber', null, [
                'required' => false,
                'documentation' => [
                    'type' => 'string',
                    'description' => 'Серийный № трубы',
                ],
            ])
            ->add('serialNoOfNipple', null, [
                'required' => false,
                'documentation' => [
                    'type' => 'string',
                    'description' => 'Серийный № ниппеля',
                ],
            ])
            ->add('couplingSerialNumber', null, [
                'required' => false,
                'documentation' => [
                    'type' => 'string',
                    'description' => 'Серийный № муфты',
                ],
            ])
            ->add('rfidTagNo', null, [
                'required' => false,
                'documentation' => [
                    'type' => 'string',
                    'description' => '№ Метки RFID',
                ],
            ])
            ->add('comment', null, [
                'required' => false,
                'documentation' => [
                    'type' => 'string',
                    'description' => 'Комментарий',
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'csrf_protection' => false,
            'allow_extra_fields' => true,
            'method' => 'POST',
            'data_class' => InventoryOver::class
        ));
    }
}