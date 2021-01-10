<?php
/**
 * Created by PhpStorm.
 * User: temerso_test
 * Date: 26.05.2020
 * Time: 10:48
 */

namespace App\Controller\Admin;


use App\Classes\Card\CardStatusHelper;
use App\Classes\Task\TaskAdminController;
use App\Entity\Card;
use App\Entity\Inspection;
use App\Entity\Marking;
use App\Entity\ReturnFromRepair;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ReturnFromRepairAdminController extends TaskAdminController
{
    const ROUTE_RETURN_FROM_RENT = 'return-from-repair'; // Вернуть из аренды и изменить статусы
    const ROUTE_CREATE_INSPECTION = 'create-inspection'; // Создать задание на испекцию

    function getEntityClass(): string
    {
        return ReturnFromRepair::class;
    }

    /**
     * Возврат из ремонта
     */
    public function returnFromRepairAction(int $id, EntityManagerInterface $em)
    {
        // 1)изменить статус у сущности ReturnFromRepair на Выполнено полностью
        $returnFromRepair = $this->findEntityAndCheck($id, $em);
        $returnFromRepair->setStatus(Marking::STATUS_COMPLETE);
        $em->persist($returnFromRepair);

        $this->getRequest()->getSession()->getFlashBag()->add("success", 'Комплект успешно возвращен из ремонта');
        // 2)изменить стаутус у карточек
        $returnFromRepair->getRepair()->getCards()->map(function (Card $card) use (&$em) {
            $card->setStatus(CardStatusHelper::STATUS_STORE);
            $em->persist($card);
        });
        $em->flush();


        $url = $this->admin->generateObjectUrl('list', $returnFromRepair);
        return new RedirectResponse($url);
    }

    /**
     * Создать инспекцию
     */
    public function createInspectionAction(int $id, EntityManagerInterface $em)
    {
        // Получаем "Возврат из аренды" и меняем статус
        $returnFromRepair = $this->findEntityAndCheck($id, $em);
        $returnFromRepair->setStatus(Marking::STATUS_CREATED);

        // Создаем инспекцию и добавляем карточки
        $inspection = new Inspection();
        $returnFromRepair->getRepair()->getCards()->map(function(Card $card) use ($inspection) {
            $inspection->addCard($card);
        });

        // Привязваем к возврату из аренды инспекцию
        $em->persist($inspection);
        $returnFromRepair->setInspection($inspection);
        $em->persist($returnFromRepair);

        // Сохраняем в базу
        $em->flush();
        // Доступы для инспекции, без этого другие роли не смог зайти
        $this->admin->createObjectSecurity($inspection);

        $url = $this->adminRoute->getActionRoute(Inspection::class, 'edit', ['id' => $inspection->getId()]);
        return new RedirectResponse($url);
    }

    private function findEntityAndCheck(int $id, EntityManagerInterface $em)
    {
        /** @var ReturnFromRepair $returnFromRepair */
        $returnFromRepair = $em->getRepository(ReturnFromRepair::class)->find($id);

        if (!$returnFromRepair) throw new NotFoundHttpException('Запись не найденна');
        if (!$returnFromRepair->getRepair()) throw new BadRequestHttpException('Должен быть указан комплект в ремонт');
        if ($returnFromRepair->getStatus() === Marking::STATUS_COMPLETE) throw new BadRequestHttpException('Комплект уже возращен из ремонта');

        return $returnFromRepair;
    }

}