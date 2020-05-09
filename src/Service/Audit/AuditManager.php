<?php
/**
 * Created by PhpStorm.
 * User: temerso_test
 * Date: 09.05.2020
 * Time: 21:21
 */

namespace App\Service\Audit;


use Doctrine\ORM\EntityManager;

class AuditManager extends \SimpleThings\EntityAudit\AuditManager
{
    public function createAuditReader(EntityManager $em)
    {
        return new AuditReader($em, $this->getConfiguration(), $this->getMetadataFactory());
    }

}