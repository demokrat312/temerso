<?php
/**
 * Created by PhpStorm.
 * User: temerso_test
 * Date: 2020-09-08
 * Time: 11:49
 */

namespace App\Security;

use \Symfony\Component\Security\Acl\Domain\PermissionGrantingStrategy as BasePermissionGrantingStrategy;
use Symfony\Component\Security\Acl\Model\AclInterface;


class PermissionGrantingStrategy extends BasePermissionGrantingStrategy
{
    public function isGranted(AclInterface $acl, array $masks, array $sids, $administrativeMode = false)
    {

        return parent::isGranted($acl, $masks, $sids, $administrativeMode);
        // @todo переделать. Если права есть то проверяем, иначе пропускаем
        /*if ($acl->getObjectAces()) {
            return parent::isGranted($acl, $masks, $sids, $administrativeMode);
        }

        return true;*/
    }

}