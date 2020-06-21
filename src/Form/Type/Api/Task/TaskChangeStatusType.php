<?php
/**
 * Created by PhpStorm.
 * User: temerso_test
 * Date: 18.06.2020
 * Time: 13:08
 */

namespace App\Form\Type\Api\Task;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

/**
 * @see \App\Controller\API\TaskController::taskCardsAction
 */
class TaskChangeStatusType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('id', null, [
                'documentation' => [
                    'type' => 'integer',
                    'description' => 'Ключ задачи',
                ],
            ])
            ->add('taskTypeId', null, [
                'documentation' => [
                    'type' => 'integer',
                    'description' => 'Тип задачи',
                ],
            ])
            ->add('statusId', null, [
                'documentation' => [
                    'type' => 'integer',
                    'description' => 'Ключ статуса',
                ],
            ]);
    }

}