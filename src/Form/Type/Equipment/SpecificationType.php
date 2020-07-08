<?php
/**
 * Created by PhpStorm.
 * User: temerso_test
 * Date: 2020-07-08
 * Time: 17:49
 */

namespace App\Form\Type\Equipment;


use App\Entity\EquipmentKitSpecification;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SpecificationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('refTypeEquipment')
            ->add('refTypeDisembarkation')
            ->add('outerDiameterOfThePipe')
            ->add('pipeWallThickness')
            ->add('refTypeThread')
            ->add('odlockNipple')
            ->add('idlockNipple')
            ->add('pipeLength')
            ->add('shoulderAngle')
            ->add('turnkeyLengthNipple')
            ->add('turnkeyLengthCoupling')
            ->add('refThreadCoating')
            ->add('refInnerCoating')
            ->add('refHardbandingCoupling')
            ->add('comment')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => EquipmentKitSpecification::class,
        ]);
    }
}