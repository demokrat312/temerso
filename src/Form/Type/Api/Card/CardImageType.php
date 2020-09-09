<?php
/**
 * Created by PhpStorm.
 * User: temerso_test
 * Date: 28.06.2020
 * Time: 14:04
 */

namespace App\Form\Type\Api\Card;


use Sonata\MediaBundle\Provider\Pool;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;

class CardImageType extends AbstractType
{
    /**
     * @var Pool
     */
    private $pool;

    public function __construct(Pool $pool)
    {
        $this->pool = $pool;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('image', FileType::class, [
                'required' => true,
//                'constraints' => [
//                    new File([
////                        'maxSize' => '1024k',
//                        'mimeTypes' => [
//                            'image/jpeg',
//                            'image/jpeg',
//                            'image/png',
//                            'image/x-png',
//                        ],
//                        'mimeTypesMessage' => 'Please upload a valid image type(jpg, png, jpeg)',
//                    ])
//                ],
                'documentation' => [
                    'type' => 'file',
                    'description' => 'Изображение',
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'csrf_protection' => false,
            'allow_extra_fields' => true,
            'method' => 'POST',
            'block_prefix' => '',
            'block_name' => '',
        ));
    }
}