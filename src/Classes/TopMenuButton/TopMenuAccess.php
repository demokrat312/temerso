<?php
/**
 * Created by PhpStorm.
 * User: temerso_test
 * Date: 29.05.2020
 * Time: 00:02
 */

namespace App\Classes\TopMenuButton;


class TopMenuAccess
{
    private $roleList = [];
    private $statusList = [];
    private $modeList = [];
    private $buttonList = [];
    private $typeList = []; // Постановщик или исполнитель

    /**
     * @return mixed
     */
    public function getRoleList()
    {
        return $this->roleList;
    }

    /**
     * @param mixed $roleList
     * @return $this
     */
    public function setRoleList($roleList)
    {
        $this->roleList = (array)$roleList;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getStatusList()
    {
        return $this->statusList;
    }

    /**
     * @param mixed $statusList
     * @return $this
     */
    public function setStatusList($statusList)
    {
        $this->statusList = (array)$statusList;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getModeList()
    {
        return $this->modeList;
    }

    /**
     * @param mixed $modeList
     * @return $this
     */
    public function setModeList($modeList)
    {
        $this->modeList = (array)$modeList;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getButtonList()
    {
        return $this->buttonList;
    }

    /**
     * @param mixed $buttonList
     * @return $this
     */
    public function setButtonList($buttonList)
    {
        $this->buttonList = (array)$buttonList;
        return $this;
    }

    /**
     * @return array
     */
    public function getTypeList(): array
    {
        return $this->typeList;
    }

    /**
     * @param array $typeList
     * @return $this
     */
    public function setTypeList(array $typeList)
    {
        $this->typeList = $typeList;
        return $this;
    }
}