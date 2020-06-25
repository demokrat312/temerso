<?php
/**
 * Created by PhpStorm.
 * User: temerso_test
 * Date: 18.06.2020
 * Time: 13:08
 */

namespace App\Form\Type\Api\Task;


use App\Form\Type\Api\Card\CardItemType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;

class TaskItemType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('id', null, [
                'documentation' => [
                    'type' => 'integer',
                    'description' => 'Ключ',
                ],
            ])
            ->add('statusId', null, [
                'documentation' => [
                    'type' => 'integer',
                    'description' => 'Статус задачи, ключ',
                ],
            ])
            ->add('statusTitle', null, [
                'documentation' => [
                    'type' => 'string',
                    'description' => 'Статус задачи, название',
                ],
            ])
            ->add('taskTypeId', null, [
                'documentation' => [
                    'type' => 'integer',
                    'description' => 'Тип задания. Ключ',
                ],
            ])
            ->add('taskTypeTitle', null, [
                'documentation' => [
                    'type' => 'string',
                    'description' => 'Тип задания. Название',
                ],
            ])
            ->add('createdByFio', null, [
                'documentation' => [
                    'type' => 'string',
                    'description' => 'Кто создал. ФИО',
                ],
            ])
            ->add('executorFio', null, [
                'documentation' => [
                    'type' => 'string',
                    'description' => 'Исполнитель. ФИО',
                ],
            ])
            ->add('comment', null, [
                'documentation' => [
                    'type' => 'string',
                    'description' => 'Комментарий/Примечание',
                ],
            ])
            ->add('cardList', CollectionType::class, [
                'entry_type' => CardItemType::class,
                'documentation' => [
                    'description' => 'Список карточек',
                ],
            ])
            ;
    }

}