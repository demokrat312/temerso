<?php
/**
 * Created by PhpStorm.
 * User: temerso_test
 * Date: 21.06.2020
 * Time: 14:29
 */

namespace App\Controller\API;


use App\Classes\ApiParentController;
use App\Entity\Card;
use App\Entity\Kit;
use App\Form\Type\Kit\KitType;
use App\Repository\CardRepository;
use Doctrine\ORM\EntityManagerInterface;
use Nelmio\ApiDocBundle\Annotation\Security;
use Swagger\Annotations as SWG;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Nelmio\ApiDocBundle\Annotation\Model;
use App\Form\Data\Api\Kit\KitData;
use App\Form\Data\Api\Kit\KitCardsData;

/**
 * Комплект для постановщика
 *
 * @Route("/api/kit/")
 *
 * @SWG\Tag(name="kit - комплект для постановщика")
 */
class KitController extends ApiParentController
{
    /**
     * Создание комплекта
     *
     * @Route("create", methods={"POST"}, name="api_kit_create")
     *
     * @SWG\Parameter(
     *    name="form",
     *    in="body",
     *    description="Данные для сохранения",
     *    @Model(type=KitData::class)
     * ),
     *
     * @SWG\Response(
     *     response="200",
     *     description="OK!",
     *     @SWG\Schema(
     *           type="string"
     *     )
     * )
     *
     * @SWG\Response(
     *     response="404",
     *     description="Если хотя бы одна карточка не найдена",
     *     @SWG\Schema(
     *           type="object",
     *           @SWG\Property(property="message", type="string"),
     *           @SWG\Property(property="notFoundCards", type="array", @SWG\Items(ref=@Model(type=KitCardsData::class))),
     *     )
     * )
     *
     * @Security(name="Bearer")
     */
    public function createAction(Request $request, EntityManagerInterface $em, TokenStorageInterface $storage)
    {
        $kitForm = $this->createForm(KitType::class);
        $kitForm->submit($request->request->all());

        if ($kitForm->isValid()) {
            /** @var CardRepository $rep */
            /** @var KitData $kitData */
            $rep = $em->getRepository(Card::class);
            $kitData = $kitForm->getData();
            $cards = $rep->findByKit($kitData);

            $cardsNotFound = [];
            foreach ($kitData->getCards() as $cardData) {
                $found = false;
                foreach ($cards as $card) {
                    if ($cardData->getRfidTagNo() === $card->getRfidTagNo()) {
                        $found = true;
                        break;
                    }
                }
                if (!$found) {
                    $cardsNotFound[] = $cardData->getRfidTagNo();
                }
            }

            if (count($cardsNotFound)) {
                return $this->errorResponse('Некоторые карточки не найденны', self::STATUS_CODE_404, [
                    'notFoundCards' => $cardsNotFound
                ]);

            }
            $kit = new Kit();
            $kit->setComment($kitData->getComment());
            foreach ($cards as $card) {
                $kit->addCard($card);
            }
            $em->persist($kit);
            $em->flush();

            return $this->defaultResponse(self::OK);
        } else {
            return $this->formErrorResponse($kitForm);
        }
    }
}