<?php
/**
 * Created by PhpStorm.
 * User: temerso_test
 * Date: 28.04.2020
 * Time: 20:07
 */

namespace App\Form\Type\Kit;


use App\Entity\CardFields;
use App\Form\Data\Api\Kit\KitCardsData;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class KitCardsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('rfidTagNo')
            ->add('sortOrder')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => KitCardsData::class,
            'fieldsType' => []
        ]);
    }
}