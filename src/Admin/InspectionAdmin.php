<?php

namespace App\Admin;

use App\Classes\Task\TaskAdminParent;
use App\Classes\Task\TaskItem;
use App\Classes\Utils;
use App\Entity\CardTemporary;
use App\Entity\Inspection;
use App\Entity\Marking;
use Sonata\AdminBundle\Route\RouteCollection;
use Sonata\AdminBundle\Show\ShowMapper;

/**
 * 6) Инспекция/Дефектоскопия
 */
class InspectionAdmin extends TaskAdminParent
{
    public function configure()
    {
        $this->setTemplate('show', 'inspection/show.html.twig');
    }

    protected function configureShowFields(ShowMapper $showMapper)
    {
        parent::configureShowFields($showMapper);

        /** @var Inspection $inspection */
        $inspection = $this->getRoot()->getSubject();
        if ($inspection && $inspection->getCardsTemporary()->count() === 0) {
            $this->createCardTemporary($inspection);
        }
    }

    /**
     * @param Inspection $object
     */
    public function postPersist($object)
    {
        $this->createCardTemporary($object);
    }

    private function createCardTemporary(Inspection $inspection)
    {
        //<editor-fold desc="Создаем временные карточки">
        foreach ($inspection->getCards() as $card) {
            $cardTemporary = (new CardTemporary())
                ->setCard($card)
                ->setTaskTypeId(TaskItem::getTaskType(get_class($inspection), true));

            Utils::copyObject($cardTemporary, $card);

            $inspection->addCardTemporary($cardTemporary);
            $this->getEntityManager()->persist($cardTemporary);
        }

        $this->getEntityManager()->persist($inspection);
        $this->getEntityManager()->flush();
        //</editor-fold>
    }
}