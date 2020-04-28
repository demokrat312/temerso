<?php
/**
 * Created by PhpStorm.
 * User: temerso_test
 * Date: 28.04.2020
 * Time: 20:07
 */

namespace App\Form\Type;


use App\Entity\CardFields;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CardFieldsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $index = $builder->getName();
        $fieldsType = $options['fieldsType'];
        if (isset($fieldsType[$index])) {
            $fieldType = $fieldsType[$index];

            $builder->add('value', $fieldType['type'], $fieldType['options']);
        } else {
            $builder->add('value');
        }
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => CardFields::class,
            'fieldsType' => []
        ]);
    }
}