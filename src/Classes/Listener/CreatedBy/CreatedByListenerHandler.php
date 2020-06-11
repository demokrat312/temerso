<?php
/**
 * Created by PhpStorm.
 * User: temerso_test
 * Date: 11.06.2020
 * Time: 09:11
 */

namespace App\Classes\Listener\CreatedBy;


use Symfony\Component\Security\Core\Security;

class CreatedByListenerHandler
{
    /**
     * @var Security
     */
    private $security;

    /**
     * CreatedByListenerInterface constructor.
     */
    public function __construct(Security $security)
    {
        $this->security = $security;
    }
    public function prePersist(CreatedByListenerInterface $entity)
    {
        $entity->setCreatedBy($this->security->getUser());
    }
}