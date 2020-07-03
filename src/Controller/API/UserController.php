<?php

namespace App\Controller\API;


use App\Classes\ApiParentController;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Nelmio\ApiDocBundle\Annotation\Security;
use Swagger\Annotations as SWG;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Nelmio\ApiDocBundle\Annotation\Model;

/**
 * Карточки
 *
 * @Route("/api/user/")
 *
 * @SWG\Tag(name="user")
 */
class UserController extends ApiParentController
{
    /**
     * Получаем текущего пользователя, если id=0 или пользователя по id, если id > 0
     *
     * @Route("item", methods={"GET"}, name="api_user_item")
     *
     * @SWG\Parameter(
     *    name="id",
     *    in="query",
     *    type="number",
     *    required=false,
     *    description="Ключ пользователя по умолчанию 0"
     * ),
     *
     * \@SWG\Parameter( name="XDEBUG_SESSION", in="header", required=true, type="string", default="xdebug" )
     *
     * @SWG\Response(
     *     response="200",
     *     description="Информация о пользователе",
     *     @Model(type=\App\Form\Type\Api\User\UserItemType::class)
     * )
     *
     * @Security(name="Bearer")
     *
     * @param Request $request
     */
    public function itemAction(Request $request, EntityManagerInterface $em, TokenStorageInterface $storage)
    {
        //<editor-fold desc="Получаем пользователя">
        $userId = (int)$request->get('id');
        if (!$userId) {
            $userId = $storage->getToken()->getUser()->getId();
        }
        $user = $em->getRepository(User::class)->find($userId);
        if (!$user) {
            return $this->errorResponse('Пользователь не найден');
        }
        //</editor-fold>

        $userArray = $this->serialize($user, USER::SERIALIZE_GROUP_API_ITEM);
        return $this->defaultResponse($userArray);
    }

}