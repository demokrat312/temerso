<?php
/**
 * Created by PhpStorm.
 * User: temerso_test
 * Date: 2020-07-12
 * Time: 22:18
 */

namespace App\Classes\Task;


trait InstanceTrait
{
    private static $instance;

    static public function ins(): self
    {
        if (!self::$instance) {
            self::$instance = new self();
        }

        return self::$instance;
    }
}