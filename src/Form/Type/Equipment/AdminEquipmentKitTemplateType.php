<?php
/**
 * Created by PhpStorm.
 * User: temerso_test
 * Date: 23.05.2020
 * Time: 20:24
 */

namespace App\Form\Type\Equipment;


use App\Entity\Card;
use Sonata\AdminBundle\Admin\Pool;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\EventListener\ResizeFormListener;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\Options;
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
        if ($options['allow_add'] && $options['prototype']) {
            $prototypeOptions = array_replace([
                'required' => $options['required'],
                'label' => $options['prototype_name'] . 'label__',
            ], $options['entry_options']);

            if (null !== $options['prototype_data']) {
                $prototypeOptions['data'] = $options['prototype_data'];
            }

            $prototype = $builder->create($options['prototype_name'], $options['entry_type'], $prototypeOptions);
            $builder->setAttribute('prototype', $prototype->getForm());
        }

        $resizeListener = new ResizeFormListener(
            $options['entry_type'],
            $options['entry_options'],
            $options['allow_add'],
            $options['allow_delete'],
            $options['delete_empty']
        );

        $builder->addEventSubscriber($resizeListener);
    }

    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        $view->vars['fieldShowName'] = $options['field_show_name'];
        $view->vars['cardAdmin'] = $this->pool->getAdminByClass(Card::class);
        $view->vars['values'] = $form->getData();


        $view->vars = array_replace($view->vars, [
            'allow_add' => $options['allow_add'],
            'allow_delete' => $options['allow_delete'],
        ]);

        if ($form->getConfig()->hasAttribute('prototype')) {
            $prototype = $form->getConfig()->getAttribute('prototype');
            $view->vars['prototype'] = $prototype->setParent($form)->createView($view);
        }
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $entryOptionsNormalizer = function (Options $options, $value) {
            $value['block_name'] = 'entry';

            return $value;
        };

        $resolver->setDefaults([
            'field_show_name' => '',
            'compound' => true,
            'multiple' => true,
            'allow_add' => true,
            'entry_type' => null,
            'by_reference' => false,
        ]);


        $resolver->setNormalizer('entry_options', $entryOptionsNormalizer);
        $resolver->setAllowedTypes('delete_empty', ['bool', 'callable']);
    }

    public function getParent()
    {
        return CollectionType::class;
    }
}