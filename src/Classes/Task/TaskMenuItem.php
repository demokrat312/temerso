<?php
/**
 * Created by PhpStorm.
 * User: temerso_test
 * Date: 28.05.2020
 * Time: 10:25
 */

namespace App\Classes\Task;


class TaskMenuItem
{
    /**
     * @var string
     */
    private $title;
    /**
     * @var string
     */
    private $route;
    /**
     * @var string
     */
    private $routeTitle;

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @param string $title
     * @return $this
     */
    public function setTitle(string $title)
    {
        $this->title = $title;
        return $this;
    }

    /**
     * @return string
     */
    public function getRoute(): string
    {
        return $this->route;
    }

    /**
     * @param string $route
     * @return $this
     */
    public function setRoute(string $route)
    {
        $this->route = $route;
        return $this;
    }

    /**
     * @return string
     */
    public function getRouteTitle(): string
    {
        return $this->routeTitle;
    }

    /**
     * @param string $routeTitle
     * @return $this
     */
    public function setRouteTitle(string $routeTitle)
    {
        $this->routeTitle = $routeTitle;
        return $this;
    }
}