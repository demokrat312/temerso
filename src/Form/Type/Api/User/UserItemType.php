<?php
/**
 * Created by PhpStorm.
 * User: temerso_test
 * Date: 18.06.2020
 * Time: 13:14
 */

namespace App\Form\Type\Api\User;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class UserItemType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('id', null, [
                'documentation' => [
                    'type' => 'integer',
                    'description' => 'Ключ пользователя',
                ],
            ])
            ->add('fio', null, [
                'documentation' => [
                    'type' => 'string',
                    'description' => 'ФИО',
                ],
            ])
            ->add('roleName', null, [
                'documentation' => [
                    'type' => 'string',
                    'description' => 'Ключ роли',
                ],
            ])
            ->add('roleTitle', null, [
                'documentation' => [
                    'type' => 'string',
                    'description' => 'Название роли',
                ],
            ])
            ->add('phone', null, [
                'required' => false,
                'documentation' => [
                    'type' => 'string',
                    'description' => 'Номер телефона',
                ],
            ])
            ->add('email', null, [
                'required' => false,
                'documentation' => [
                    'type' => 'string',
                    'description' => 'Почта',
                ],
            ])
        ;
    }
}