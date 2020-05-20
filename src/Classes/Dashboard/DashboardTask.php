<?php
/**
 * Created by PhpStorm.
 * User: temerso_test
 * Date: 12.05.2020
 * Time: 19:40
 */

namespace App\Classes\Dashboard;


class DashboardTask extends DashboardParent
{
    protected function getBlocks(): array
    {
        return [
            (new DBlock())
                ->setClass('col-lg-3 col-xs-6')
                ->setPosition('top')
                ->setType(DBlock::TYPE_ADMIN_LIST)
                ->setSettings((new DSettingAdminList())
                    ->setGroups(['taskDashboard'])
                )->toArray(),
        ];
    }
}