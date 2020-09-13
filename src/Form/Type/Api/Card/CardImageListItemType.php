<?php
/**
 * Created by PhpStorm.
 * User: temerso_test
 * Date: 28.06.2020
 * Time: 14:04
 */

namespace App\Form\Type\Api\Card;


use App\Form\Data\Api\Card\CardImageData;
use App\Form\Data\Api\Card\CardImageListData;
use App\Form\Data\Api\Card\CardImageListItemData;
use Sonata\MediaBundle\Provider\Pool;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;

class CardImageListItemType extends AbstractType
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
            ->add('cardId', null, [
                'required' => true,
                'documentation' => [
                    'type' => 'integer',
                    'description' => 'Ключ, задачи',
                ],
            ])
            ->add('images', FileType::class, [
                'required' => true,
                'multiple' => true,
                'documentation' => [
                    'type' => 'file',
                    'description' => 'Изображения',
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'csrf_protection' => false,
            'data_class' => CardImageListItemData::class,
            'allow_extra_fields' => true,
            'method' => 'POST',
            'block_prefix' => '',
            'block_name' => '',
        ));
    }
}