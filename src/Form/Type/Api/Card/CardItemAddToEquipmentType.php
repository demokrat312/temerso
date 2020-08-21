<?php
/**
 * Created by PhpStorm.
 * User: temerso_test
 * Date: 18.06.2020
 * Time: 13:14
 */

namespace App\Form\Type\Api\Card;


use App\Form\Data\Api\Card\CardAddToEquipmentData;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CardItemAddToEquipmentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('pipeSerialNumber', null, [
                'required' => false,
                'documentation' => [
                    'type' => 'number',
                    'description' => 'Серийный № трубы',
                ],
            ])
            ->add('couplingSerialNumber', null, [
                'required' => false,
                'documentation' => [
                    'type' => 'number',
                    'description' => 'Серийный № муфты',
                ],
            ])
            ->add('serialNoOfNipple', null, [
                'required' => false,
                'documentation' => [
                    'type' => 'number',
                    'description' => 'Серийный № ниппеля',
                ],
            ])
            ->add('rfidTagNo', null, [
                'required' => false,
                'documentation' => [
                    'type' => 'string',
                    'description' => '№ Метки RFID',
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'csrf_protection' => false,
            'allow_extra_fields' => true,
            'method' => 'POST',
            'data_class' => CardAddToEquipmentData::class
        ));
    }
}