<?php
/**
 * Created by PhpStorm.
 * User: temerso_test
 * Date: 2020-07-08
 * Time: 17:49
 */

namespace App\Form\Type\Equipment;


use App\Entity\EquipmentKitSpecification;
use App\Form\Data\Api\Equipment\ConfirmationData;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ConfirmationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('taskId')
            ->add('cards', CollectionType::class, [
                'entry_type' => ConfirmationCardsType::class,
                'allow_add' => true
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => ConfirmationData::class,
        ]);
    }
}