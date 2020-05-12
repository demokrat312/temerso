<?php
/**
 * Created by PhpStorm.
 * User: temerso_test
 * Date: 12.05.2020
 * Time: 19:40
 */

namespace App\Classes\Dashboard;


use Closure;
use Sonata\AdminBundle\Action\DashboardAction;

class DashboardReference
{
    public function changeBlocks(DashboardAction $dashboard)
    {
        $newBlock = $this->getBlocks();
        $changeDashboardConfig = Closure::bind(function ($dashboard) use ($newBlock) {
            $dashboard->dashboardBlocks = $newBlock;
        }, null, DashboardAction::class);

        $changeDashboardConfig($dashboard);
    }

    private function getBlocks()
    {
        return [
            (new DBlock())
                ->setClass('col-lg-3 col-xs-6')
                ->setPosition('top')
                ->setType(DBlock::TYPE_ADMIN_LIST)
                ->setSettings((new DSettingAdminList())
                    ->setGroups(['cardDashboardRef'])
                )->toArray(),
            (new DBlock())
                ->setClass('col-lg-3 col-xs-6')
                ->setPosition('top')
                ->setType(DBlock::TYPE_ADMIN_LIST)
                ->setSettings((new DSettingAdminList())
                    ->setGroups(['cardDashboardFields'])
                )->toArray(),
        ];
    }
}