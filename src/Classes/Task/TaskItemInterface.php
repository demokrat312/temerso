<?php
/**
 * Created by PhpStorm.
 * User: temerso_test
 * Date: 19.06.2020
 * Time: 10:39
 */

namespace App\Classes\Task;


use App\Entity\User;
use Doctrine\Common\Collections\Collection;

interface TaskItemInterface
{
    public function getId(): int;
    public function getStatus(): ?int;
    public function getCreatedBy(): User;
    public function getExecutor(): ?User;
    public function getCards(): Collection;
}