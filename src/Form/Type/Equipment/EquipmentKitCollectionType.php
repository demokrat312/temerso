<?php
/**
 * Created by PhpStorm.
 * User: temerso_test
 * Date: 2020-07-06
 * Time: 02:48
 */

namespace App\Form\Type\Equipment;


use App\Entity\Card;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;

class EquipmentKitCollectionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('kits', CollectionType::class, [
                'label' => 'Карточки',
                'entry_type' => AdminEquipmentKitTemplateType::class,
                'allow_add' => true,
            ]);
    }
}