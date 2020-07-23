<?php
/**
 * Created by PhpStorm.
 * User: temerso_test
 * Date: 2020-07-23
 * Time: 15:15
 */

namespace App\Controller\API;

use App\Classes\ApiParentController;
use App\Entity\Inventory;
use App\Form\Data\Api\Inventory\InventoryData;
use App\Form\Type\Api\Inventory\InventoryType;
use Doctrine\ORM\EntityManagerInterface;
use Nelmio\ApiDocBundle\Annotation\Model;
use Nelmio\ApiDocBundle\Annotation\Security;
use Swagger\Annotations as SWG;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/api/inventory/")
 *
 * @SWG\Tag(name="inventory - инвентаризация")
 */
class InventoryController extends ApiParentController
{
    /**
     * Добавляем излишек и инвентаризации.
     * Данные добавляются к уже существующему излишку, если такой есть
     *
     * @Route("add-over", methods={"POST"}, name="api_inventory_add_over")
     *
     * @SWG\Parameter(
     *    name="form",
     *    in="body",
     *    description="Излишек",
     *    @Model(type=InventoryType::class)
     * ),
     *
     * @SWG\Response(
     *     response="200",
     *     description="Если излишек сохраниться вернет 'OK!'",
     *     @SWG\Schema( type="string"),
     * )
     *
     * @SWG\Response(
     *     response="422",
     *     description="Ошибка валидации входящих данных",
     *     @SWG\Schema(
     *            ref=@Model(type=\App\Classes\Error\ErrorResponse::class)
     *      ),
     * )
     *
     * @Security(name="Bearer")
     */
    public function addOver(Request $request, EntityManagerInterface $em)
    {
        $form = $this->createForm(InventoryType::class);
        $form->submit($request->request->all());

        if($form->isValid()) {
            /** @var InventoryData $data */
            $data = $form->getData();

            /** @var Inventory $inventory */
            $inventory = $em->getRepository(Inventory::class)->find($data->getId());
            if(!$inventory) {
                return $this->errorResponse('Инвентаризация по указаному id не найдена');
            }

            foreach ($data->getOverList() as $inventoryOver) {
                $inventory->addOver($inventoryOver);
            }

            $em->persist($inventory);
            $em->flush();

            return $this->defaultResponse(self::OK);

        }

        return $this->formErrorResponse($form);
    }
}