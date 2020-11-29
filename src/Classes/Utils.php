<?php
/**
 * Created by PhpStorm.
 * User: temerso_test
 * Date: 19.06.2020
 * Time: 10:12
 */

namespace App\Classes;


use Doctrine\Common\Collections\ArrayCollection;

/**
 * Функции общего применения
 *
 * Class Utils
 * @package App\Classes
 */
class Utils
{
    /**
     * in_array где массив имеет вложеность
     */
    public static function in_array_r($needle, $haystack, $strict = false)
    {
        foreach ($haystack as $item) {
            if (($strict ? $item === $needle : $item == $needle) || (is_array($item) && self::in_array_r($needle, $item, $strict))) {
                return true;
            }
        }

        return false;
    }

    /**
     * Если первое значение тоже массив
     */
    public static function in_array($needle, $haystack)
    {
        if (is_array($needle)) {
            return count(array_diff($needle, $haystack)) < count($needle);
        } else {
            return self::in_array($needle, $haystack);
        }
    }

    /**
     * Копируем значения 2 объекта в 1
     */
    public static function copyObject($objTo, $objFrom)
    {
        $objToMethods = array_filter(get_class_methods($objTo), function ($methodName) {
            return strpos($methodName, 'set') === 0;
        });
        foreach ($objToMethods as $setMethodTo) {
            $getMethodFrom = 'get' . substr($setMethodTo, 3);
            if (method_exists($objFrom, $getMethodFrom) && $objFrom->{$getMethodFrom}() !== null) {
                $objTo->{$setMethodTo}($objFrom->{$getMethodFrom}());
            }
        }

        return $objTo;
    }

    public static function array_merge_recursive_distinct(array &$array1, array &$array2)
    {
        $merged = $array1;

        foreach ($array2 as $key => &$value) {
            if (is_array($value) && isset ($merged [$key]) && is_array($merged [$key])) {
                $merged [$key] = Utils::array_merge_recursive_distinct($merged [$key], $value);
            } else {
                $merged [$key] = $value;
            }
        }

        return $merged;
    }

    public static function filterDuplicate($list, $isCollection = true)
    {
        //Костыль. Фильтруем повторяющиеся записи
        $duplicate = [];
        $listFiltered = [];

        foreach ($list as $item) {
            $json = json_encode($item);
            if (!in_array($json, $duplicate)) {
                $listFiltered[] = $item;
                $duplicate[] = $json;
            }
        }

        if($isCollection) {
            return new ArrayCollection($listFiltered);
        }
        return $listFiltered;
    }
}