<?php
/**
 * Created by PhpStorm.
 * User: temerso_test
 * Date: 18.06.2020
 * Time: 13:14
 */

namespace App\Form\Type\Api\Card;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CardEditType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('id', null, [
                'documentation' => [
                    'type' => 'integer',
                    'description' => 'Ключ карточки',
                ],
            ])
            ->add('taskTypeId', null, [
                'documentation' => [
                    'type' => 'integer',
                    'description' => 'Тип задачи',
                ],
            ])
            ->add('rfidTagNo', null, [
                'documentation' => [
                    'type' => 'number',
                    'description' => 'Метки RFID',
                ],
            ])
            ->add('comment', null, [
                'documentation' => [
                    'type' => 'string',
                    'description' => 'Примечание',
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'csrf_protection'    => false,
            'allow_extra_fields' => true,
            'method'             => 'POST',
        ));
    }


}