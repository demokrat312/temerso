<?php
/**
 * Created by PhpStorm.
 * User: temerso_test
 * Date: 23.05.2020
 * Time: 20:24
 */

namespace App\Form\Type;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AdminListType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);

//        $builder->resetViewTransformers();
//        $builder;
//            ->addModelTransformer(new CallbackTransformer(
//                function ($collection) {
//                    if (null === $collection) {
//                        return [];
//                    }
//
//                    $array = [];
//                    foreach ($collection as $key => $entity) {
//                        $id = $entity->getId();
//
//                        $array[] = $id;
//                    }
//
//                    return $array;
//                },
//                function ($array) {
////                    exit;
//                    // transform the string back to an array
//                    return $array;
//                }
//            ), true)
//            ->addViewTransformer(new CallbackTransformer(
//                function ($array) {
//                    if (empty($array)) {
//                        return [];
//                    }
//
//                    $entities = [];
//                    foreach ($array as $key => $id) {
//                        $entity = $this->em->getRepository(Card::class)->find($id);
//
//                        $entities[] = $entity;
//                    }
//
//                    return $entities;
//                },
//                function ($array) {
//                   $entities = [];
//                    foreach ($array as $key => $id) {
//                        $entity = $this->em->getRepository(Card::class)->find($id);
//
//                        $entities[] = $entity;
//                    }
//
//                    return $entities;
//                }
//            ), true);
    }

    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        $view->vars['fieldShowName'] = $options['field_show_name'];
        $view->vars['fields'] = $options['fields'];
        $view->vars['values'] = $form->getData();
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'field_show_name' => '',
            'fields' => [],
        ]);
    }

    public function getParent()
    {
        return \Symfony\Bridge\Doctrine\Form\Type\EntityType::class;
    }
}