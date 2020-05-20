<?php

namespace App\Classes\Dashboard;


use Closure;
use Sonata\AdminBundle\Action\DashboardAction;

abstract class DashboardParent
{
    public function changeBlocks(DashboardAction $dashboard)
    {
        $newBlock = $this->getBlocks();
        $changeDashboardConfig = Closure::bind(function ($dashboard) use ($newBlock) {
            $dashboard->dashboardBlocks = $newBlock;
        }, null, DashboardAction::class);

        $changeDashboardConfig($dashboard);
    }

    abstract protected function getBlocks(): array;
}