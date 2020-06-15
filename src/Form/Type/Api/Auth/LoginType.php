<?php
/**
 * Created by PhpStorm.
 * User: temerso_test
 * Date: 15.06.2020
 * Time: 09:10
 */

namespace App\Form\Type\Api\Auth;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class LoginType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('username')
            ->add('password')
        ;
    }

}