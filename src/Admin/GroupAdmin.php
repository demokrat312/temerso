<?php


namespace App\Admin;

use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\UserBundle\Admin\Model\GroupAdmin as BaseGroupAdmin;

class GroupAdmin extends BaseGroupAdmin
{
    protected function configureDatagridFilters(DatagridMapper $datagridMapper): void
    {
        $datagridMapper
            ->add('name', null, array('global_search' => false))
        ;
    }

}