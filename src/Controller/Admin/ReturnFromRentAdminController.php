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
use App\Entity\ReturnFromRent;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ReturnFromRentAdminController extends TaskAdminController
{
    const ROUTE_RETURN_FROM_RENT = 'return-from-rent'; // Вернуть из аренды и изменить статусы
    const ROUTE_CREATE_INSPECTION = 'create-inspection'; // Создать задание на испекцию

    function getEntityClass(): string
    {
        return ReturnFromRent::class;
    }

    /**
     * Возврат из аренды
     */
    public function returnFromRentAction(int $id, EntityManagerInterface $em)
    {
        // 1)изменить статус у сущности ReturnFromRent на Выполнено полностью
        $returnFromRent = $this->findEntityAndCheck($id, $em);
        $returnFromRent->setStatus(Marking::STATUS_COMPLETE);
        $em->persist($returnFromRent);

        $this->getRequest()->getSession()->getFlashBag()->add("success", 'Комплект успешно возвращен из аренды');
        // 2)изменить стаутус у карточек
        $returnFromRent->getEquipment()->getCards()->map(function (Card $card) use (&$em) {
            $card->setStatus(CardStatusHelper::STATUS_STORE);
            $em->persist($card);
        });
        $em->flush();


        $url = $this->admin->generateObjectUrl('list', $returnFromRent);
        return new RedirectResponse($url);
    }

    /**
     * Создать инспекцию
     */
    public function createInspectionAction(int $id, EntityManagerInterface $em)
    {
        // Получаем "Возврат из аренды" и меняем статус
        $returnFromRent = $this->findEntityAndCheck($id, $em);
        $returnFromRent->setStatus(Marking::STATUS_CREATED);

        // Создаем инспекцию и добавляем карточки
        $inspection = new Inspection();
        $returnFromRent->getEquipment()->getCards()->map(function(Card $card) use ($inspection) {
            $inspection->addCard($card);
        });

        // Привязваем к возврату из аренды инспекцию
        $em->persist($inspection);
        $returnFromRent->setInspection($inspection);
        $em->persist($returnFromRent);

        // Сохраняем в базу
        $em->flush();
        // Доступы для инспекции, без этого другие роли не смог зайти
        $this->admin->createObjectSecurity($inspection);

        $url = $this->adminRoute->getActionRoute(Inspection::class, 'edit', ['id' => $inspection->getId()]);
        return new RedirectResponse($url);
    }

    private function findEntityAndCheck(int $id, EntityManagerInterface $em)
    {
        /** @var ReturnFromRent $returnFromRent */
        $returnFromRent = $em->getRepository(ReturnFromRent::class)->find($id);

        if (!$returnFromRent) throw new NotFoundHttpException('Запись не найденна');
        if (!$returnFromRent->getEquipment()) throw new BadRequestHttpException('Должен быть указан комплект в аренду');
        if ($returnFromRent->getStatus() === Marking::STATUS_COMPLETE) throw new BadRequestHttpException('Комплект уже возращен из аренды');

        return $returnFromRent;
    }

}