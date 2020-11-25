<?php


namespace App\Classes\Type;

use App\Application\Sonata\MediaBundle\Entity\Media;
use Sonata\MediaBundle\Form\DataTransformer\ProviderDataTransformer;
use Sonata\MediaBundle\Form\Type\MediaType as BaseMediaType;
use Sonata\MediaBundle\Provider\Pool;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MediaType extends BaseMediaType
{
    public function __construct(Pool $pool, $class)
    {
        $class = Media::class;
        parent::__construct($pool, $class);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        parent::configureOptions($resolver);

        $resolver->setDefault('is_image', true);
    }

    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        parent::buildView($view, $form, $options);

        $view->vars['is_image'] = $options['is_image'];
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $dataTransformer = new ProviderDataTransformer($this->pool, $this->class, [
            'provider' => $options['provider'],
            'context' => $options['context'],
            'empty_on_new' => $options['empty_on_new'],
            'new_on_update' => $options['new_on_update'],
        ]);
        $dataTransformer->setLogger($this->logger);

        $builder->addModelTransformer($dataTransformer);

        $builder->addEventListener(FormEvents::SUBMIT, static function (FormEvent $event) {
            if ($event->getForm()->has('unlink') && $event->getForm()->get('unlink')->getData()) {
                $event->setData(null);
            }
        });

//        $this->pool->getProvider($options['provider'])->buildMediaType($builder);

        $builder->add('binaryContent', FileType::class, [
            'required' => false,
            'label' => 'widget_label_binary_content',
            'attr' => [
                'class' => 'js-file-input',
//                'class' => 'file',
//                'data-browse-on-zone-click' => true,
//                'data-drop-zone-enabled' => 'false',
//                'data-allowed-file-extensions' => '["jpg", "png", "gif"]',
//                'data-show-upload' => 'false'
            ]
        ]);

        $builder->add('unlink', CheckboxType::class, [
            'label' => 'widget_label_unlink',
            'mapped' => false,
            'data' => false,
            'required' => false,
        ]);

        $builder
            ->setAttribute('is_image', $options['is_image'])
        ;
    }


}