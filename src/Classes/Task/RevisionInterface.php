<?php


namespace App\Classes\Task;


use Doctrine\ORM\EntityManagerInterface;

interface RevisionInterface
{
    public function getIsRevision();
    public function setIsRevision($isRevision);
}