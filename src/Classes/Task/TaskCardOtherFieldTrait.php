<?php
/**
 * Created by PhpStorm.
 * User: temerso_test
 * Date: 2020-09-10
 * Time: 11:35
 */

namespace App\Classes\Task;


use App\Entity\TaskCardOtherField;

/**
 * @mixin TaskCardOtherField
 */
trait TaskCardOtherFieldTrait
{
    public function getTitles(): array
    {
        return [
            'Комментарий',
            'Оборудование есть, проблема с меткой',
        ];
    }

    public function getFields(): array
    {
        return [
            $this->getComment(),
            $this->getCommentProblemWithMark(),
        ];
    }

}