<?php
/**
 * Created by PhpStorm.
 * User: temerso_test
 * Date: 12.05.2020
 * Time: 11:44
 */

namespace App\EventSubscriber;


use Knp\Menu\MenuItem;
use Sonata\AdminBundle\Event\ConfigureMenuEvent;

/**
 * Главное меню
 *
 * Class MenuBuilderSubscriber
 * @package App\EventSubscriber
 */
class MenuBuilderSubscriber
{
    public function addMenuItems(ConfigureMenuEvent $event)
    {
        $menu = $event->getMenu();

        foreach ($menu->getChildren() as $menuKey => $menuItem) {
            // Если ключ меню совподает с label, значит label в настройка не задали и его не нужно отображать в меню
            if($menuKey === $menuItem->getLabel()) {
                $menuItem->setDisplay(false);
            }
        }

//        $menu->getChild('Каталог')->addChild('reports', [
//            'label' => 'База списанного оборудоания',
//            'route' => 'admin_empty',
//        ]);


//        $child = $menu->addChild('reports', [
//            'label' => 'База списанного оборудоания',
//            'group' => 'Каталог',
//            'route' => 'admin_empty',
//        ])->setExtras([
//            'icon' => '<i class="fa fa-bar-chart"></i>',
//            'group' => 'Каталог',
//        ]);
    }
}