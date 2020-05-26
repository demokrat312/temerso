<?php
/**
 * Created by PhpStorm.
 * User: temerso_test
 * Date: 23.05.2020
 * Time: 22:06
 */

namespace App\Classes;


interface DateListenerInterface
{
    public function setCreateAt(\DateTimeInterface $createAt);

    public function setUpdateAt(\DateTimeInterface $updateAt);
}