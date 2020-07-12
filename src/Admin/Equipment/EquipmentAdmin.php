<?php

namespace App\Admin\Equipment;

use App\Classes\ShowAdmin\ShowModeFooterActionBuilder;
use App\Classes\ShowAdmin\ShowModeFooterButtonItem;
use App\Classes\Task\TaskAdminParent;
use App\Controller\Admin\MarkingAdminController;
use App\Entity\Equipment;
use App\Entity\Marking;
use App\Form\Type\Equipment\AdminEquipmentKitTemplateType;
use App\Form\Type\Equipment\EquipmentKitType;
use Sonata\AdminBundle\Form\FormMapper;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

/**
 * Комлектация в аренду
 */
class EquipmentAdmin extends TaskAdminParent
{
    public function configure()
    {
        $this->setTemplate('show', 'equipment/show.html.twig');
    }

    protected function configureFormFields(FormMapper $editForm)
    {
        $actionButtons = new ShowModeFooterActionBuilder();

        if ($this->isCurrentRoute('create')) {
            $editForm
                ->tab('tab_one', ['label' => 'Главная', 'class' => 'col-md-12'])
                    ->with('')
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

                                'choices' => [
                                    'Единичный комплект' => Equipment::KIT_TYPE_SINGLE,
                                    'Множественный комплект' => Equipment::KIT_TYPE_MULTI,
                                ],
                            ])
                        ->add('withKit', ChoiceType::class,
                            [
                                'label' => 'Каталог',
                                'choices' => [
                                    'С выборкой из каталога' => Equipment::CATALOG_WITH,
                                    'Без выборки из каталога' => Equipment::CATALOG_WITHOUT,
                                ],
                            ])
                        ->add('cardCount', NumberType::class, ['label' => 'Укажите количество единиц оборудования', 'empty_data' => '0'])
                        ->add('kitCount', NumberType::class, ['label' => 'Укажите количество комплектов', 'empty_data' => '1'])
                        ->add('kitCardCount', TextType::class, ['label' => 'Укажите количество единиц оборудования в каждом из комплектов(через запятую)'])
                    ->end()
                ->end()
                ->tab('tab_two', ['label' => 'Комплект'])
                    ->with('')
                        ->add('kits', AdminEquipmentKitTemplateType::class, [
                            'label' => 'Карточки',
                            'entry_type' => EquipmentKitType::class,
                        ])
                    ->end()
                ->end();


            $actionButtons->addItem($actionButtons->getDefaultByKey(ShowModeFooterActionBuilder::BTN_CUSTOM_PREV));
            $actionButtons->addItem($actionButtons->getDefaultByKey(ShowModeFooterActionBuilder::BTN_CUSTOM_NEXT));
            $actionButtons->addItem($actionButtons->getDefaultByKey(ShowModeFooterActionBuilder::BTN_CREATE_AND_EDIT));

        } else {
            $editForm
                ->tab('tab_one', ['label' => 'Главная', 'class' => 'col-md-12'])
                    ->with('')
                        ->add('users', \Sonata\AdminBundle\Form\Type\ModelType::class, [
                            'property' => 'fio',
                            'multiple' => true,
                            'label' => 'Исполнители',
                            'btn_add' => false
                        ])
                    ->end()
                ->end();


            $actionButtons->addItem($actionButtons->getDefaultByKey(ShowModeFooterActionBuilder::BTN_UPDATE_AND_EDIT_AGAIN));
        }

        $actionButtons->addItem((new ShowModeFooterButtonItem())
            ->setClasses('btn btn-success')
            ->setName(ShowModeFooterActionBuilder::BTN_CUSTOM_REDIRECT)
            ->addIcon('fa-save')
            ->setRouteAction(MarkingAdminController::ROUTER_CHANGE_STATUS)
            ->setRouteQuery(http_build_query(['status' => Marking::STATUS_SEND_EXECUTION]))
            ->setTitle('Отправить на исполнение')
            ,
            );
        $this->setShowModeButtons($actionButtons->getButtonList());
    }
}