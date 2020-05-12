<?php
/**
 * Created by PhpStorm.
 * User: temerso_test
 * Date: 12.05.2020
 * Time: 19:17
 */

namespace App\Classes\Dashboard;


use App\Classes\TraitHelper\ToArrayTrait;

class DSettingStats implements DSettingInterface
{
    use ToArrayTrait;

    /**
     * @var string|null
     */
    private $code;
    /**
     * @var string|null
     */
    private $icon;
    /**
     * @var string|null
     */
    private $text;
    /**
     * @var array
     */
    private $filters = [];

    /**
     * @return string|null
     */
    public function getCode(): ?string
    {
        return $this->code;
    }

    /**
     * @param string|null $code
     * @return $this
     */
    public function setCode(?string $code)
    {
        $this->code = $code;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getIcon(): ?string
    {
        return $this->icon;
    }

    /**
     * @param string|null $icon
     * @return $this
     */
    public function setIcon(?string $icon)
    {
        $this->icon = $icon;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getText(): ?string
    {
        return $this->text;
    }

    /**
     * @param string|null $text
     * @return $this
     */
    public function setText(?string $text)
    {
        $this->text = $text;
        return $this;
    }

    /**
     * @return array
     */
    public function getFilters(): array
    {
        return $this->filters;
    }

    /**
     * @param array $filters
     * @return $this
     */
    public function setFilters(array $filters)
    {
        $this->filters = $filters;
        return $this;
    }
}