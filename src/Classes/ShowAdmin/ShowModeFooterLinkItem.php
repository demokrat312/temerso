<?php
/**
 * Created by PhpStorm.
 * User: temerso_test
 * Date: 25.05.2020
 * Time: 14:25
 */

namespace App\Classes\ShowAdmin;


class ShowModeFooterLinkItem extends ShowModeFooterItemParent
{
    private $adminAction;

    function getType(): string
    {
        return ShowModeFooterItemParent::TYPE_LINK;
    }

    /**
     * @return mixed
     */
    public function getAdminAction()
    {
        return $this->adminAction;
    }

    /**
     * @param mixed $adminAction
     * @return $this
     */
    public function setAdminAction($adminAction)
    {
        $this->adminAction = $adminAction;
        return $this;
    }

}