<?php
/**
 * Created by PhpStorm.
 * User: temerso_test
 * Date: 2020-08-01
 * Time: 14:24
 */

namespace App\Classes\Card;


use App\Classes\Task\InstanceTrait;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\DoctrineORMAdminBundle\Admin\FieldDescription;

class CardListHelper
{
    use InstanceTrait;

    /**
     * @param $field
     * @param $fieldAfterName
     * @param ListMapper $list
     */
    public function addAfter(string $field, string $fieldAfterName, ListMapper $list)
    {
        /** @var \Sonata\DoctrineORMAdminBundle\Admin\FieldDescription[] $tempList */
        $tempList = [];
        $itemToInsert = null;
        foreach ($list->keys() as $key) {
            if ($field === $key) {
                $itemToInsert = $list->get($key);
            } else {
                $tempList[] = $list->get($key);
            }
            $list->remove($key);
        }
        foreach ($tempList as $item) {
            $list->add($item);
            if ($item->getName() === $fieldAfterName) {
                $list->add($itemToInsert);
            }
        }
    }

    public function isAjax()
    {
        return !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest';
    }

    public function requestFrom(string $className)
    {
        if (!CardListHelper::ins()->isAjax()) return false;

        if (strpos($className, '\\')) {
            preg_match('/\\\\(?<url>\w+$)/', $className, $matches);
            $url = strtolower($matches['url']);
        } else {
            $url = $className;
        }
        return isset($_SERVER['HTTP_REFERER']) && strpos($_SERVER['HTTP_REFERER'], "/$url/") !== false;
    }

    public function removeLink(FieldDescription $fieldDescription)
    {
        $options = $fieldDescription->getOptions();
        $fieldDescription->setOptions(array_merge(
            $options, [
                'identifier' => false,
                'route' => false,
            ]
        ));
    }

    public function removeSort(FieldDescription $fieldDescription)
    {
        $options = $fieldDescription->getOptions();
        $fieldDescription->setOptions(array_merge(
            $options, [
                'sortable' => false,
            ]
        ));
    }
}