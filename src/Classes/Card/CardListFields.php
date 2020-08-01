<?php
/**
 * Created by PhpStorm.
 * User: temerso_test
 * Date: 2020-08-01
 * Time: 14:50
 */

namespace App\Classes\Card;


use App\Classes\MainAdmin;
use App\Classes\Task\InstanceTrait;
use App\Entity\Repair;
use App\Entity\ReturnFromRepair;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\DoctrineORMAdminBundle\Admin\FieldDescription;

class CardListFields
{
    use InstanceTrait;

    private function getDefault(ListMapper $listMapper)
    {
        $listMapper
            ->add('pipeSerialNumber', null, array_merge(MainAdmin::VIEW_LINK, ['label' => 'Серийный № трубы', 'sortable' => true,]))
            ->add('generalName', null, array_merge(MainAdmin::VIEW_LINK, [
                'label' => 'Название',
                'header_class' => 'js-field-general-name'
            ]))
            ->add('statusTitle', null, ['label' => 'Статус'])
            // Name of the action (show, edit, history, delete, etc)
            ->add('_action', null, [
                'label' => 'Действия',
                'actions' => [
                    'show' => [],
                    'history' => [],
                    'edit' => [
                        // You may add custom link parameters used to generate the action url
                        'link_parameters' => [
                            'full' => true,
                        ]
                    ],
                    'delete' => [],
                ]
            ]);
    }

    public function getFields(ListMapper $listMapper)
    {
        $this->getDefault($listMapper);

        if (CardListHelper::ins()->requestFrom(Repair::class)) {
            $this->repair($listMapper);
        } else if (CardListHelper::ins()->requestFrom(ReturnFromRepair::class)) {
            $this->returnFromRepair($listMapper);

        }
    }

    private function repair(ListMapper $listMapper)
    {
        $listMapper->add('repairCardImgRequired.required', 'admin_checked', [
            'label' => 'Фотография',
            'input_name_mask' => '{formId}[cardImgRequired][{id}][required]',
            'input_parent_mask' => '{formId}[cardImgRequired][{id}][card]',
        ]);
        CardListHelper::ins()->addAfter('repairCardImgRequired.required', 'generalName', $listMapper);

    }

    private function returnFromRepair(ListMapper $listMapper)
    {
        $listMapper->remove('batch');
        $listMapper->remove('_action');
        // Удаляем все ссылки
        foreach ($listMapper->keys() as $key) {
            /** @var FieldDescription $fieldDescription */
            $fieldDescription = $listMapper->get($key);
            CardListHelper::ins()->removeLink($fieldDescription);
            CardListHelper::ins()->removeSort($fieldDescription);
        }

        $listMapper->add('action', 'actions',
            array(
                'label' => 'Загрузка изображений',
                'actions' => array(
                    'usage' => array('template' =>'crud/list_action_custom.html.twig')
                ),
                'link' => 'admin_app_card_edit',
                'title' => 'Загрузить изображение',
                'withId' => true,
            )
        );
    }
}