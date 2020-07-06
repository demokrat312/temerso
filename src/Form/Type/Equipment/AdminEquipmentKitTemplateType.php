<?php
/**
 * Created by PhpStorm.
 * User: temerso_test
 * Date: 23.05.2020
 * Time: 20:24
 */

namespace App\Form\Type\Equipment;


use App\Entity\Card;
use App\Entity\EquipmentKit;
use Sonata\AdminBundle\Admin\Pool;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\CallbackTransformer;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AdminEquipmentKitTemplateType extends AbstractType
{
    /**
     * @var Pool
     */
    private $pool;

    /**
     * AdminEquipmentKitTemplateType constructor.
     */
    public function __construct(Pool $pool)
    {
        $this->pool = $pool;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title')
            ->add('card', EntityType::class, [
                'class' => Card::class,
                'multiple' => true
            ]);

//        $builder->resetViewTransformers();
        $builder
            ->addModelTransformer(new CallbackTransformer(
                function ($collection) {
                    if (null === $collection) {
                        return [];
                    }

                    $array = [];
                    foreach ($collection as $key => $entity) {
                        $id = $entity->getId();

                        $array[] = $id;
                    }

                    return $array;
                },
                function ($array) {
//                    exit;
                    // transform the string back to an array
                    return $array;
                }
            ), true)
            ->addViewTransformer(new CallbackTransformer(
                function ($array) {
                    if (empty($array)) {
                        return [];
                    }

                    $entities = [];
                    foreach ($array as $key => $id) {
                        $entity = $this->em->getRepository(Card::class)->find($id);

                        $entities[] = $entity;
                    }

                    return $entities;
                },
                function ($array) {
                   $entities = [];
                    foreach ($array as $key => $id) {
                        $equipmentKit = new EquipmentKit();
                        $equipmentKit->setTitle($key);
                        $entity = $this->em->getRepository(Card::class)->find($id);

                        $entities[] = $entity;
                    }

                    return $entities;
                }
            ), true)
        ;
    }

    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        $view->vars['fieldShowName'] = $options['field_show_name'];
        $view->vars['cardAdmin'] = $this->pool->getAdminByClass(Card::class);
        $view->vars['values'] = $form->getData();
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'field_show_name' => '',
            'compound' => true,
            'multiple' => true,
            'allow_add' => true,
        ]);
    }

    public function getParent()
    {
//        return CollectionType::class;
        return \Symfony\Bridge\Doctrine\Form\Type\EntityType::class;
    }
}