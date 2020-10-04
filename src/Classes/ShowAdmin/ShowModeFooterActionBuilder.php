<?php
/**
 * Created by PhpStorm.
 * User: temerso_test
 * Date: 25.05.2020
 * Time: 16:57
 */

namespace App\Classes\ShowAdmin;


use App\Controller\Admin\MarkingAdminController;
use App\Entity\Marking;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ShowModeFooterActionBuilder
{
    const BTN_UPDATE_AND_EDIT_AGAIN = 'btn_update_and_edit_again';
    const BTN_UPDATE_AND_LIST = 'btn_update_and_list';
    const LINK_DELETE = 'link_delete';
    const LINK_EDIT_ACL = 'link_edit_acl';
    const BTN_CREATE_AND_EDIT = 'btn_create_and_edit';
    const BTN_CREATE_AND_LIST = 'btn_create_and_list';
    const BTN_CREATE_AND_CREATE = 'btn_create_and_create';

    const BTN_CUSTOM_REDIRECT = 'btn_custom_redirect';
    const BTN_CUSTOM_PREV = 'btn_custom_prev';
    const BTN_CUSTOM_NEXT = 'btn_custom_next';

    const BTN_ID_CREATE_TASK = 'btn_id_create_task';
    const BTN_ID_STATUS_SEND_EXECUTION = 'btn_id_status_send_execution';

    /**
     * @var array |ShowModeFooterItemParent[]
     */
    private $buttonList = [];

    /**
     * @var array |ShowModeFooterItemParent[]
     */
    private $buttonDefaultList = [];

    public function __construct()
    {
        $this->buildDefault();
    }

    public function buildDefault()
    {
        $this->buttonDefaultList = [
            (new ShowModeFooterButtonItem())
                ->setClasses('btn btn-success')
                ->setName(self::BTN_CREATE_AND_EDIT)
                ->addIcon('fa-save')
                ->setTitle('btn_create_and_edit_again')
            ,
            (new ShowModeFooterButtonItem())
                ->setClasses('btn btn-success')
                ->setName(self::BTN_CREATE_AND_LIST)
                ->addIcon('fa-save')
                ->addIcon('fa-list')
                ->setTitle('btn_create_and_return_to_list')
            ,
            (new ShowModeFooterButtonItem())
                ->setClasses('btn btn-success')
                ->setName(self::BTN_CREATE_AND_CREATE)
                ->addIcon('fa-plus-circle')
                ->setTitle('btn_create_and_create_a_new_one')
            ,
            (new ShowModeFooterButtonItem())
                ->setClasses('btn btn-success')
                ->setName(self::BTN_UPDATE_AND_EDIT_AGAIN)
                ->addIcon('fa-save')
                ->setTitle('btn_update_and_edit_again')
            ,
            (new ShowModeFooterButtonItem())
                ->setClasses('btn btn-success')
                ->setName(self::BTN_UPDATE_AND_LIST)
                ->addIcon('fa-list')
                ->setTitle('btn_update_and_return_to_list')
            ,
            (new ShowModeFooterLinkItem())
                ->setClasses('btn btn-danger')
                ->setName(self::LINK_DELETE)
                ->addIcon('fa-minus-circle')
                ->setTitle('link_delete')
                ->setAdminAction('delete')
            ,
            (new ShowModeFooterLinkItem())
                ->setClasses('btn btn-info')
                ->setName(self::LINK_EDIT_ACL)
                ->addIcon('fa-users')
                ->setTitle('link_edit_acl')
                ->setAdminAction('acl')
            ,
            (new ShowModeFooterButtonItem())
                ->setClasses('btn btn-info js-prev-tab')
                ->setName(self::BTN_CUSTOM_PREV)
                ->addIcon('fa-arrow-circle-left')
                ->setTitle('Назад')
                ->setButtonType('button')
            ,
            (new ShowModeFooterButtonItem())
                ->setClasses('btn btn-info js-next-tab')
                ->setName(self::BTN_CUSTOM_NEXT)
                ->addIcon('fa-arrow-circle-right')
                ->setTitle('Далее')
                ->setButtonType('button')
            ,
            (new ShowModeFooterButtonItem())
                ->setId(self::BTN_ID_CREATE_TASK)
                ->setClasses('btn btn-success')
                ->setName(ShowModeFooterActionBuilder::BTN_CUSTOM_REDIRECT)
                ->addIcon('fa-save')
                ->setRouteAction(MarkingAdminController::ROUTER_SHOW)
                ->setTitle('Создать задачу')
            ,
            (new ShowModeFooterButtonItem())
                ->setId(self::BTN_ID_STATUS_SEND_EXECUTION)
                ->setClasses('btn btn-success')
                ->setName(ShowModeFooterActionBuilder::BTN_CUSTOM_REDIRECT)
                ->addIcon('fa-save')
                ->setRouteAction(MarkingAdminController::ROUTER_CHANGE_STATUS)
                ->setRouteQuery(http_build_query(['status' => Marking::STATUS_SEND_EXECUTION]))
                ->setTitle('Создать задачу и отправить на исполнение')

            ,

        ];
    }

    public function getDefaultByKey(string $key)
    {
        foreach ($this->buttonDefaultList as $menuItem) {
            if ($menuItem->getName() === $key) {
                return $menuItem;
            }
        }
        throw new NotFoundHttpException('Кнопка с названием ' . $key . ' не найденна');
    }

    public function getDefaultById(string $id)
    {
        foreach ($this->buttonDefaultList as $menuItem) {
            if ($menuItem->getId() === $id) {
                return $menuItem;
            }
        }
        throw new NotFoundHttpException('Кнопка с id ' . $id . ' не найденна');
    }

    public function getDefaultCreate(string $key)
    {
        return [
            $this->getDefaultByKey(self::BTN_CREATE_AND_EDIT),
            $this->getDefaultByKey(self::BTN_CREATE_AND_LIST),
            $this->getDefaultByKey(self::BTN_CREATE_AND_CREATE),
        ];
    }

    public function getDefaultEdit(string $key)
    {
        return [
            $this->getDefaultByKey(self::BTN_UPDATE_AND_EDIT_AGAIN),
            $this->getDefaultByKey(self::BTN_UPDATE_AND_LIST),
            $this->getDefaultByKey(self::LINK_DELETE),
            $this->getDefaultByKey(self::LINK_EDIT_ACL),
        ];
    }

    public function addItem(ShowModeFooterItemParent $menuItem)
    {
        $this->buttonList[] = $menuItem;
    }

    /**
     * @return array
     */
    public function getButtonList(): array
    {
        return $this->buttonList;
    }

}