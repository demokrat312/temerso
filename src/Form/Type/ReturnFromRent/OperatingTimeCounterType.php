<?php
/**
 * Created by PhpStorm.
 * User: temerso_test
 * Date: 2020-08-27
 * Time: 15:58
 */

namespace App\Form\Type\ReturnFromRent;


use App\Entity\CardFields;
use App\Entity\OperatingTimeCounter;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class OperatingTimeCounterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('returnFromRentDate', DateTimeType::class, [
                'label' => 'Дата прихода из аренды',
                'widget' => 'single_text'
            ])
            ->add('workStartDate', null, ['label' => 'Дата прихода из аренды',])
            ->add('wellNumber', null, ['label' => '№ скважины',])
            ->add('spoAmount', null, ['label' => 'Кол-во СПО',])
            ->add('penetrationFrom', null, ['label' => 'Проходка, интервал от',])
            ->add('penetrationTo', null, ['label' => 'Проходка, интервал до',])
            ->add('penetrationTotal', null, ['label' => 'Проходка, итого',])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => OperatingTimeCounter::class,
        ]);
    }

}