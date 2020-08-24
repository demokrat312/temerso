<?php
/**
 * Created by PhpStorm.
 * User: temerso_test
 * Date: 18.06.2020
 * Time: 13:14
 */

namespace App\Form\Type\Api\Card;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
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
                'required' => false,
                'documentation' => [
                    'type' => 'integer',
                    'description' => 'Тип задачи',
                ],
            ])
            ->add('rfidTagNo', null, [
                'required' => false,
                'documentation' => [
                    'type' => 'string',
                    'description' => 'Метки RFID',
                ],
            ])
            ->add('accounting', null, [
                'required' => false,
                'documentation' => [
                    'type' => 'integer',
                    'description' => 'Учет/Инвентаризация',
                ],
            ])
            ->add('comment', null, [
                'required' => false,
                'documentation' => [
                    'type' => 'string',
                    'description' => 'Примечание',
                ],
            ])
            ->add('commentProblemWithMark', null, [
                'required' => false,
                'documentation' => [
                    'type' => 'string',
                    'description' => 'Оборудование есть, проблема с меткой(для инспекции)',
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