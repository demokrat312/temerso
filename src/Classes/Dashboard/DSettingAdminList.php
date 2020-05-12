<?php
/**
 * Created by PhpStorm.
 * User: temerso_test
 * Date: 12.05.2020
 * Time: 19:17
 */

namespace App\Classes\Dashboard;


use App\Classes\TraitHelper\ToArrayTrait;

class DSettingAdminList implements DSettingInterface
{
    use ToArrayTrait;

    private $attr;
    private $extra_cache_keys;
    /**
     * @var array|null
     */
    private $groups;
    private $template;
    private $ttl;
    private $use_cache;

    /**
     * @return mixed
     */
    public function getAttr()
    {
        return $this->attr;
    }

    /**
     * @param mixed $attr
     * @return $this
     */
    public function setAttr($attr)
    {
        $this->attr = $attr;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getExtraCacheKeys()
    {
        return $this->extra_cache_keys;
    }

    /**
     * @param mixed $extra_cache_keys
     * @return $this
     */
    public function setExtraCacheKeys($extra_cache_keys)
    {
        $this->extra_cache_keys = $extra_cache_keys;
        return $this;
    }

    /**
     * @return array|null
     */
    public function getGroups(): ?array
    {
        return $this->groups;
    }

    /**
     * @param array|null $groups
     * @return $this
     */
    public function setGroups(?array $groups)
    {
        $this->groups = $groups;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getTemplate()
    {
        return $this->template;
    }

    /**
     * @param mixed $template
     * @return $this
     */
    public function setTemplate($template)
    {
        $this->template = $template;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getTtl()
    {
        return $this->ttl;
    }

    /**
     * @param mixed $ttl
     * @return $this
     */
    public function setTtl($ttl)
    {
        $this->ttl = $ttl;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getUseCache()
    {
        return $this->use_cache;
    }

    /**
     * @param mixed $use_cache
     * @return $this
     */
    public function setUseCache($use_cache)
    {
        $this->use_cache = $use_cache;
        return $this;
    }
}