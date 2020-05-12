<?php
/**
 * Created by PhpStorm.
 * User: temerso_test
 * Date: 12.05.2020
 * Time: 19:13
 */

namespace App\Classes\Dashboard;


use App\Classes\TraitHelper\ToArrayTrait;

class DBlock
{
    use ToArrayTrait;

    /**
     * @link https://symfony.com/doc/master/bundles/SonataAdminBundle/reference/dashboard.html
     *
     * @link https://stackoverflow.com/questions/24177144/the-block-type-sonata-admin-block-admin-list-does-not-exist
     * sonata.user.block.menu:
     * sonata.user.block.account:
     */
    const TYPE_ADMIN_LIST = 'sonata.admin.block.admin_list';
    const TYPE_SEARCH_RESULT = 'sonata.admin.block.search_result';
    const TYPE_STATS = 'sonata.admin.block.stats';
    const TYPE_TEXT = 'sonata.block.service.text';

    /**
     * @var string|null
     */
    private $class;
    /**
     * @var string|null
     */
    private $position;
    /**
     * @var string|null
     */
    private $type;
    /**
     * @var DSettingInterface|null
     */
    private $settings;
    /**
     * @var array
     */
    private $roles = [];

    /**
     * @return string|null
     */
    public function getClass(): ?string
    {
        return $this->class;
    }

    /**
     * @param string|null $class
     * @return $this
     */
    public function setClass(?string $class)
    {
        $this->class = $class;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getPosition(): ?string
    {
        return $this->position;
    }

    /**
     * @param string|null $position
     * @return $this
     */
    public function setPosition(?string $position)
    {
        $this->position = $position;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getType(): ?string
    {
        return $this->type;
    }

    /**
     * @param string|null $type
     * @return $this
     */
    public function setType(?string $type)
    {
//        if($type === self::TYPE_ADMIN_LIST) {
//            $this->setSettings(null);
//        }
        $this->type = $type;
        return $this;
    }

    /**
     * @return DSettingInterface|null
     */
    public function getSettings(): ?DSettingInterface
    {
        return $this->settings;
    }

    /**
     * @param DSettingInterface|null $settings
     * @return $this
     */
    public function setSettings(?DSettingInterface $settings)
    {
        $this->settings = $settings;
        return $this;
    }

    /**
     * @return array
     */
    public function getRoles(): array
    {
        return $this->roles;
    }

    /**
     * @param array $roles
     * @return $this
     */
    public function setRoles(array $roles)
    {
        $this->roles = $roles;
        return $this;
    }
}