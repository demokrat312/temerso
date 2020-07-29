<?php
/**
 * Created by PhpStorm.
 * User: temerso_test
 * Date: 2020-07-29
 * Time: 13:19
 */

namespace App\Form\Type\Repair;


use App\Entity\RepairCardImgRequired;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RepairImageRequiredType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('card')
            ->add('required', CheckboxType::class);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => RepairCardImgRequired::class,
            'fieldsType' => []
        ]);
    }
}