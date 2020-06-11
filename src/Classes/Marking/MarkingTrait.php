<?php
/**
 * Created by PhpStorm.
 * User: temerso_test
 * Date: 11.06.2020
 * Time: 08:32
 */

namespace App\Classes\Marking;


use App\Entity\User;

trait MarkingTrait
{
    /**
     * Тип задачи (поле для списка)
     * @return string
     */
    public function taskType()
    {
        return 'Маркировка';
    }

    /**
     * Исполнитель
     */
    public function executor()
    {
        /** @var User $user */
        $user = $this->users->first();
        return $user ? $user->getFio() : '';
    }

    /**
     * @see templates/marking/show.html.twig
     * @return mixed
     */
    public function getStatusTitle()
    {
        return self::STATUS_TITLE[$this->status];
    }
}