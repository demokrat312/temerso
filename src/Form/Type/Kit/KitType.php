<?php
/**
 * Created by PhpStorm.
 * User: temerso_test
 * Date: 28.04.2020
 * Time: 20:07
 */

namespace App\Form\Type\Kit;


use App\Entity\CardFields;
use App\Form\Data\Api\Kit\KitData;
use App\Form\Type\Kit\KitCardsType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class KitType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('comment')
            ->add('cards', CollectionType::class, [
                'entry_type' => KitCardsType::class,
                'allow_add' => true,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => KitData::class,
            'fieldsType' => []
        ]);
    }
}