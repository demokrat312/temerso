<?php
/**
 * Created by PhpStorm.
 * User: temerso_test
 * Date: 25.05.2020
 * Time: 16:57
 */

namespace App\Classes\ShowAdmin;


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
        ];
    }

    public function getDefaultByKey(string $key)
    {
        foreach ($this->buttonDefaultList as $menuItem) {
            if ($menuItem->getName() === $key) {
                return $menuItem;
            }
        }
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