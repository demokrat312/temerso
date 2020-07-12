<?php

namespace App\Controller\API;


use App\Classes\ApiParentController;
use App\Entity\Equipment;
use App\Entity\User;
use App\Repository\EquipmentRepository;
use Doctrine\ORM\EntityManagerInterface;
use Nelmio\ApiDocBundle\Annotation\Model;
use Nelmio\ApiDocBundle\Annotation\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Swagger\Annotations as SWG;

/**
 * Комплектация в аренду
 *
 * @Route("/api/equipment/")
 * @SWG\Tag(name="equipment - Комплектация в аренду")
 */
class EquipmentApiController extends ApiParentController
{
    /**
     * Комплектация в аренду. Получение записи по id
     *
     * @Route("item", methods={"GET"}, name="api_equipment_item")
     *
     * @SWG\Parameter(
     *    name="id",
     *    in="query",
     *    type="number",
     *    description="Ключ записи. Нужно брать из задачи поле id с taskTypeId=4."
     * ),
     *
     *
     * @SWG\Response(
     *     response="200",
     *     description="Возвращаем запись",
     *     @Model(type=Equipment::class, groups={\App\Classes\ApiParentController::GROUP_API_DEFAULT})
     * )
     *
     * @Security(name="Bearer")
     */
    public function item(Request $request, EntityManagerInterface $em, TokenStorageInterface $storage)
    {
        $id = $request->get('id');
        /** @var User $user */
        $user = $storage->getToken()->getUser();
        /** @var EquipmentRepository $rep */
        $rep = $em->getRepository(Equipment::class);

        $equipment = $rep->findTask($id, $user->getId());
        if (!$equipment) {
            return $this->errorResponse('Запись не найденна или у вас нету доступа');
        }

        return $this->defaultResponse($this->toArray($equipment, [ApiParentController::GROUP_API_DEFAULT]));
    }
}