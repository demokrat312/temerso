<?php
/**
 * Created by PhpStorm.
 * User: temerso_test
 * Date: 2020-10-04
 * Time: 18:26
 */

namespace App\Classes\Task;


use App\Entity\Card;
use App\Entity\CardTemporary;
use Doctrine\Common\Collections\Collection;

/**
 * Задачи для которых нужны временные карточки
 */
interface TaskWithCardsTemporaryInterface extends TaskItemInterface
{
    /** @return CardTemporary[] */
    public function getCardsTemporary(): Collection;

    public function getCardTemporary(Card $card): ?CardTemporary;

    public function addCardTemporary(CardTemporary $cardTemporary);

    public function allowEditCardTemporary(): bool;
}