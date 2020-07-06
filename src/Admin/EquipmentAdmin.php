<?php

namespace App\Admin;

use App\Classes\ShowAdmin\ShowModeFooterActionBuilder;
use App\Classes\ShowAdmin\ShowModeFooterButtonItem;
use App\Classes\Task\TaskAdminParent;
use App\Controller\Admin\MarkingAdminController;
use App\Entity\EquipmentKit;
use App\Form\Type\Equipment\AdminEquipmentKitTemplateType;
use App\Form\Type\Equipment\EquipmentKitType;
use Sonata\AdminBundle\Form\FormMapper;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;

/**
 * Комлектация в аренду
 */
class EquipmentAdmin extends TaskAdminParent
{
    public function configure()
    {
        $this->setTemplate('show', 'marking/show.html.twig');
    }

    protected function configureFormFields(FormMapper $editForm)
    {
        $editForm
            ->tab('tab_one', ['label' => 'Главная', 'class' => 'col-md-12'])
                ->with('block_one')
                    ->add('mainReason', null, ['label' => 'Основание формирования комплекта'])
                    ->add('users', \Sonata\AdminBundle\Form\Type\ModelType::class, [
                        'property' => 'fio',
                        'multiple' => true,
                        'label' => 'Исполнители',
                        'btn_add' => false
                    ])
                    ->add('files', \Sonata\AdminBundle\Form\Type\CollectionType::class, array(
                        'entry_type' => \Sonata\MediaBundle\Form\Type\MediaType::class,
                        'label' => 'Приложения',
                        'entry_options' => array(
                            'provider' => 'sonata.media.provider.file',
                            'context' => 'card',
                            'empty_on_new' => false,
                            'new_on_update' => false,
                        ),
                        'allow_add' => true,
                        'by_reference' => false,
                        'allow_delete' => true,
                    ))
                    ->add('tenantName', null, ['label' => 'Название компании-арендатора'])
                    ->add('kitType', ChoiceType::class,
                        [
                            'label' => 'Выбрать тип комплекта',
                            'mapped' => false,
                            'choices'  => [
                                'Единичный комплект' => 'single',
                                'Множественный комплект' => 'multi',
                            ],
                        ])
                    ->add('kitCount', NumberType::class, ['label' => 'Укажите количество комплектов', 'empty_data' => 1, 'mapped' => false])
                    ->add('kitItemCountType', NumberType::class, ['label' => 'Укажите количество единиц оборудования в каждом из комплектов(через запятую)', 'mapped' => false])
                    ->add('withKit', ChoiceType::class,
                        [
                            'label' => 'Каталог',
                            'mapped' => false,
                            'choices'  => [
                                'С выборкой из каталога' => 'withCatalog',
                                'Без выборки из каталога' => 'withoutCatalog',
                            ],
                        ])

                ->end()
            ->end()
            ->tab('tab_two')
                ->with('block_two')
//                    ->add('kits', CollectionType::class, [
//                        'entry_type' => AdminEquipmentKitTemplateType::class,
//    //                    'class' => EquipmentKit::class,
//                        'label' => 'Карточки',
//                        'allow_add' => true, //This should do the trick.
//                    ])
                        ->add('kits', AdminEquipmentKitTemplateType::class, [
                            'label' => 'Карточки',
                            'class' => EquipmentKit::class,
//                            'entry_type' => EquipmentKitType::class,
//                            'entity_options' => ['class' => EquipmentKit::class],
//                            'allow_add' => true,
                        ])
                ->end()
            ->end()
        ;


        $actionButtons = new ShowModeFooterActionBuilder();

        if ($this->isCurrentRoute('create')) {
            $actionButtons->addItem($actionButtons->getDefaultByKey(ShowModeFooterActionBuilder::BTN_CUSTOM_PREV));
            $actionButtons->addItem($actionButtons->getDefaultByKey(ShowModeFooterActionBuilder::BTN_CUSTOM_NEXT));
            $actionButtons->addItem((new ShowModeFooterButtonItem())
                ->setClasses('btn btn-success')
                ->setName(ShowModeFooterActionBuilder::BTN_CUSTOM_REDIRECT)
                ->addIcon('fa-save')
                ->setRouteAction(MarkingAdminController::ROUTER_SHOW)
                ->setTitle('Сохранить')
                ,
                );
        } else {
            $actionButtons->addItem($actionButtons->getDefaultByKey(ShowModeFooterActionBuilder::BTN_UPDATE_AND_EDIT_AGAIN));
        }

        $this->setShowModeButtons($actionButtons->getButtonList());
    }
}