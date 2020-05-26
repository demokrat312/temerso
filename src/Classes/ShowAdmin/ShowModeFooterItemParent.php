<?php
/**
 * Created by PhpStorm.
 * User: temerso_test
 * Date: 25.05.2020
 * Time: 14:25
 */

namespace App\Classes\ShowAdmin;


abstract class ShowModeFooterItemParent
{
    const TYPE_BUTTON = 'type_button';
    const TYPE_LINK = 'type_link';

    private $classes;
    private $icon = [];
    private $title;
    private $name;

    abstract function getType(): string;

    /**
     * @return mixed
     */
    public function getClasses()
    {
        return $this->classes;
    }

    /**
     * @param mixed $classes
     * @return $this
     */
    public function setClasses($classes)
    {
        $this->classes = $classes;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getIcon()
    {
        return $this->icon;
    }

    /**
     * @param mixed $icon
     * @return $this
     */
    public function addIcon($icon)
    {
        $this->icon[] = $icon;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param mixed $title
     * @return $this
     */
    public function setTitle($title)
    {
        $this->title = $title;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     * @return $this
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

}