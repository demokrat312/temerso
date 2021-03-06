<?php
/**
 * Created by PhpStorm.
 * User: temerso_test
 * Date: 25.05.2020
 * Time: 14:25
 */

namespace App\Classes\ShowAdmin;


class ShowModeFooterButtonItem extends ShowModeFooterItemParent
{
    private $routeAction;
    private $routeQuery;
    private $buttonType = 'submit'; // button|submit|reset

    function getType(): string
    {
        return ShowModeFooterItemParent::TYPE_BUTTON;
    }

    /**
     * @return mixed
     */
    public function getRouteAction()
    {
        return $this->routeAction;
    }

    /**
     * @param mixed $routeAction
     * @return $this
     */
    public function setRouteAction($routeAction)
    {
        $this->routeAction = $routeAction;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getRouteQuery()
    {
        return $this->routeQuery;
    }

    /**
     * @param mixed $routeQuery
     * @return $this
     */
    public function setRouteQuery($routeQuery)
    {
        $this->routeQuery = $routeQuery;
        return $this;
    }

    /**
     * @return string
     */
    public function getButtonType(): string
    {
        return $this->buttonType;
    }

    /**
     * @param string $buttonType
     * @return $this
     */
    public function setButtonType(string $buttonType)
    {
        $this->buttonType = $buttonType;
        return $this;
    }
}