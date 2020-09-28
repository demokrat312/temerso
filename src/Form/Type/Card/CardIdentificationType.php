<?php
/**
 * Created by PhpStorm.
 * User: temerso_test
 * Date: 2020-08-06
 * Time: 17:13
 */

namespace App\Form\Type\Card;


use App\Form\Data\Api\Card\CardIdentificationData;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CardIdentificationType extends AbstractType
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
            ->add('couplingSerialNumber', null, [
                'required' => false,
                'documentation' => [
                    'type' => 'string',
                    'description' => 'Серийный № муфты',
                ],
            ])
            ->add('serialNoOfNipple', null, [
                'required' => false,
                'documentation' => [
                    'type' => 'string',
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
        $resolver->setDefaults([
            'data_class' => CardIdentificationData::class
        ]);
    }

}