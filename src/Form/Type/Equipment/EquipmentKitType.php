<?php
/**
 * Created by PhpStorm.
 * User: temerso_test
 * Date: 2020-07-06
 * Time: 03:24
 */

namespace App\Form\Type\Equipment;


use App\Entity\Card;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class EquipmentKitType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title')
            ->add('card', EntityType::class, [
                'class' => Card::class,
                'multiple' => true
            ]);
    }
}