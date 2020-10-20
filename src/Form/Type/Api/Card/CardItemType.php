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

class CardItemType extends AbstractType
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
            ->add('fullName', null, [
                'documentation' => [
                    'type' => 'string',
                    'description' => 'Полное название. Группировка основных полей',
                ],
            ])
            ->add('pipeSerialNumber', null, [
                'documentation' => [
                    'type' => 'string',
                    'description' => 'Серийный № трубы',
                ],
            ])
            ->add('serialNoOfNipple', null, [
                'documentation' => [
                    'type' => 'string',
                    'description' => 'Серийный № ниппеля',
                ],
            ])
            ->add('couplingSerialNumber', null, [
                'documentation' => [
                    'type' => 'string',
                    'description' => 'Серийный № муфты',
                ],
            ])
            ->add('rfidTagNo', null, [
                'documentation' => [
                    'type' => 'number',
                    'description' => 'Метки RFID',
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
            ->add('accounting', null, [
                'documentation' => [
                    'type' => 'number',
                    'description' => 'Учет/Инвентаризация. По умолчанию у создаваемых карточек будет проставляться 1.',
                ],
            ])
            ->add('taskTypeId', null, [
                'documentation' => [
                    'type' => 'number',
                    'description' => 'Тип задачи',
                ],
            ])
            ->add('taskId', null, [
                'required' => false,
                'documentation' => [
                    'type' => 'number',
                    'description' => 'Ключ задачи. Для каждой задачи свои ключи',
                ],
            ])
            ->add('cardImgRequired', null, [
                'required' => false,
                'documentation' => [
                    'type' => 'boolean',
                    'description' => 'Обязательность приложения фото (Для комплектации в ремонт)',
                ],
            ])
            ->add('sortOrder', null, [
                'documentation' => [
                    'type' => 'integer',
                    'description' => 'Порядковый номер в списке карточек для задачи',
                ],
            ])
        ;
    }
}