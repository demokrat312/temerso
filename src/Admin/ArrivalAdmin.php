<?php
/**
 * Created by PhpStorm.
 * User: temerso_test
 * Date: 02.05.2020
 * Time: 18:21
 */

namespace App\Admin;

use App\Classes\MainAdmin;
use App\Classes\ShowAdmin\ShowModeFooterActionBuilder;
use App\Classes\ShowAdmin\ShowModeFooterButtonItem;
use App\Controller\Admin\MarkingAdminController;
use App\Entity\Arrival;
use App\Entity\Card;
use App\Entity\Marking;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use Sonata\AdminBundle\Show\ShowMapper;

/**
 * Приход
 *
 * Class ArrivalAdmin
 * @package App\Admin
 */
class ArrivalAdmin extends MainAdmin
{
    public function configure()
    {
        $this->setTemplate('edit', 'arrival/edit.html.twig');
    }

    protected function configureRoutes(RouteCollection $collection)
    {
        $collection
            ->add('excel', $this->getRouterIdParameter().'/excel')
            ->remove('export')
            ->remove('acl')
        ;
    }


    public function getContainer(){
        return $this->getConfigurationPool()->getContainer();
    }

    protected function configureListFields(ListMapper $list)
    {
        $list
            ->add('id', null, array_merge(self::VIEW_LINK, ['label' => 'ID Партии']))
            ->add('numberUnitsInBatch', null, array_merge(self::VIEW_LINK, ['label' => 'Количество единиц товара в партии']))
            ->add('dateArrival', null, ['label' => 'Дата прихода'])
            ->add('numberAndDatePurchase', null, ['label' => '№ договора покупки, дата покупки'])
        ;
//            ->add('id', null, self::VIEW_LINK);

        // Name of the action (show, edit, history, delete, etc)
        $list->add('_action', null, [
            'label' => 'Действия',
            'actions' => [
                'show' => [],
                'edit' => [],
                'excel' => [
                    'template' => 'arrival/list__action_excel.html.twig',
                ],
            ]
        ]);
    }

    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->with('general', ['label' => 'Главная', 'class' => 'col-md-12'])
                ->add('numberUnitsInBatch', null, ['label' => 'Количество единиц товара в партии'])
                    ->add('dateArrival', null, ['label' => 'Дата прихода'])
                ->add('numberAndDatePurchase', null, ['label' => '№ договора покупки, дата покупки'])
                ->add('files', null, array('label' => 'Приложение сканов', 'template' => 'crud/show/file.html.twig'))
            ->end()->end()
            ->with('cardGeneral', ['label' => 'Основые поля карточные', 'class' => 'col-md-6'])
                ->add('refTypeEquipment', null, ['label' => 'Тип оборудования (выбор значений из списка)'])
                ->add('location', null, ['label' => 'Местоположение оборудования'])
                ->add('operatingHours', null, ['label' => 'Наработка моточасов (числовое поле)'])
                ->add('outerDiameterOfThePipe', null, ['label' => 'Наружный диаметр трубы, (мм)'])
                ->add('pipeWallThickness', null, ['label' => 'Толщина стенки трубы, (мм)'])
                ->add('refTypeDisembarkation', null, ['label' => 'Тип высадки'])
                ->add('refPipeStrengthGroup', null, ['label' => 'Группа прочности трубы'])
                ->add('refTypeThread', null, ['label' => 'Тип резьбы'])
                ->add('odlockNipple', null, ['label' => 'O.D. Замка ниппель  (мм)'])
                ->add('dfchamferNipple', null, ['label' => 'D.F.  Фаска ниппель (мм)'])
                ->add('lpcThreadLengthNipple', null, ['label' => 'LPC   Длина резьбы ниппель (мм)'])
                ->add('nippleNoseDiameter', null, ['label' => 'Диаметр носика ниппеля'])
                ->add('odlockCoupling', null, ['label' => 'O.D. Замка муфта  (мм)'])
                ->add('dfchamferCoupling', null, ['label' => 'D.F.  Фаска муфта (мм)'])
                ->add('lbcThreadLengthCoupler', null, ['label' => 'LBC Длина резьбы муфта (мм)'])
                ->add('qcBoreDiameterCoupling', null, ['label' => 'QC Диаметр расточки муфта(мм)'])
                ->add('idlockNipple', null, ['label' => 'I.D. Замка ниппель  (мм)'])
                ->add('shoulderAngle', null, ['label' => 'Угол заплечика (градус)'])
                ->add('turnkeyLengthNipple', null, ['label' => 'Длина под ключ ниппель, (мм)'])
                ->add('turnkeyLengthCoupling', null, ['label' => 'Длина под ключ муфта, (мм)'])
                ->add('refThreadCoating', null, ['label' => 'Покрытие резьбы'])
                ->add('refInnerCoating', null, ['label' => 'Внутреннее покрытие'])
                ->add('refHardbandingNipple', null, ['label' => 'Хардбендинг (ниппель)'])
                ->add('refHardbandingCoupling', null, ['label' => 'Хардбендинг (муфта)'])
                ->add('btCertificateNumber', null, ['label' => 'Номер Сертификата на комплект БТ'])
                ->add('refWearClass', null, ['label' => 'Класс износа'])
                ->add('amountCard', null, ['label' => 'Количество карточек'])
            ->end()->end()
            ->with('cardIndividual', ['label' => 'Индивидуальные значения', 'class' => 'col-md-6'])
                ->add('groupPipeSerialNumber', null, ['label' => 'Серийные номера группы труб'])
                ->add('groupSerialNoOfNipple', null, ['label' => 'Серийные номера группы ниппелей'])
                ->add('groupCouplingSerialNumber', null, ['label' => 'Серийные номера группы муфт'])
                ->add('groupPipeLength', null, ['label' => 'Длина трубы'])
                ->add('groupWeightOfPipe', null, ['label' => 'Вес трубы'])
            ->end()->end()
        ;
    }

    protected function configureFormFields(FormMapper $form)
    {
        $form
            ->tab('general', ['label' => 'Главная'])
                ->add('numberUnitsInBatch', null, ['label' => 'Количество единиц товара в партии'])
                ->add('dateArrival', null, ['label' => 'Дата прихода'])
                ->add('numberAndDatePurchase', null, ['label' => '№ договора покупки, дата покупки'])
                ->add('files', \Sonata\AdminBundle\Form\Type\CollectionType::class, array(
                    'entry_type' => \Sonata\MediaBundle\Form\Type\MediaType::class,
                    'label' => 'Приложение сканов',
                    'entry_options' => array(
                        'provider' => 'sonata.media.provider.file',
                        'context' => 'arrival',
                        'empty_on_new' => false,
                        'new_on_update' => false,
                    ),
                    'allow_add' => true,
                    'by_reference' => false,
                    'allow_delete' => true,
                ))
//                ->add('next',  ButtonType::class, [
//                    'label' => 'Дальше',
//                    'mapped' => false,
//                    'attr' => ['class' => 'js-next-tab btn btn-primary'],
//                ])
            ->end()->end();

        if ($this->isCurrentRoute('create')) {
            $form
                ->tab('cardGeneral', ['label' => 'Основые поля карточные'])
                    ->add('refTypeEquipment', null, ['label' => 'Тип оборудования (выбор значений из списка)'])
                    ->add('location', null, ['label' => 'Местоположение оборудования'])
                    ->add('operatingHours', null, ['label' => 'Наработка моточасов (числовое поле)'])
                    ->add('outerDiameterOfThePipe', null, ['label' => 'Наружный диаметр трубы, (мм)'])
                    ->add('pipeWallThickness', null, ['label' => 'Толщина стенки трубы, (мм)'])
                    ->add('refTypeDisembarkation', null, ['label' => 'Тип высадки'])
                    ->add('refPipeStrengthGroup', null, ['label' => 'Группа прочности трубы'])
                    ->add('refTypeThread', null, ['label' => 'Тип резьбы'])
                    ->add('odlockNipple', null, ['label' => 'O.D. Замка ниппель  (мм)'])
                    ->add('dfchamferNipple', null, ['label' => 'D.F.  Фаска ниппель (мм)'])
                    ->add('lpcThreadLengthNipple', null, ['label' => 'LPC   Длина резьбы ниппель (мм)'])
                    ->add('nippleNoseDiameter', null, ['label' => 'Диаметр носика ниппеля'])
                    ->add('odlockCoupling', null, ['label' => 'O.D. Замка муфта  (мм)'])
                    ->add('dfchamferCoupling', null, ['label' => 'D.F.  Фаска муфта (мм)'])
                    ->add('lbcThreadLengthCoupler', null, ['label' => 'LBC Длина резьбы муфта (мм)'])
                    ->add('qcBoreDiameterCoupling', null, ['label' => 'QC Диаметр расточки муфта(мм)'])
                    ->add('idlockNipple', null, ['label' => 'I.D. Замка ниппель  (мм)'])
                    ->add('shoulderAngle', null, ['label' => 'Угол заплечика (градус)'])
                    ->add('turnkeyLengthNipple', null, ['label' => 'Длина под ключ ниппель, (мм)'])
                    ->add('turnkeyLengthCoupling', null, ['label' => 'Длина под ключ муфта, (мм)'])
                    ->add('refThreadCoating', null, ['label' => 'Покрытие резьбы'])
                    ->add('refInnerCoating', null, ['label' => 'Внутреннее покрытие'])
                    ->add('refHardbandingNipple', null, ['label' => 'Хардбендинг (ниппель)'])
                    ->add('refHardbandingCoupling', null, ['label' => 'Хардбендинг (муфта)'])
                    ->add('btCertificateNumber', null, ['label' => 'Номер Сертификата на комплект БТ'])
                    ->add('refWearClass', null, ['label' => 'Класс износа'])
                    ->add('amountCard', null, ['label' => 'Количество карточек'])
//                     ->add('next2',  ButtonType::class, [
//                            'label' => 'Дальше',
//                            'mapped' => false,
//                            'attr' => ['class' => 'js-next-tab btn btn-primary'],
//                        ])
                ->end()->end()
                ->tab('cardIndividual', ['label' => 'Индивидуальные значения'])
                    ->add('groupPipeSerialNumber', null, ['label' => 'Серийные номера группы труб'])
                    ->add('groupSerialNoOfNipple', null, ['label' => 'Серийные номера группы ниппелей'])
                    ->add('groupCouplingSerialNumber', null, ['label' => 'Серийные номера группы муфт'])
                    ->add('groupPipeLength', null, ['label' => 'Длина трубы'])
                    ->add('groupWeightOfPipe', null, ['label' => 'Вес трубы'])
                ->end()->end()
            ;
        }
        $actionButtons = new ShowModeFooterActionBuilder();

        if ($this->isCurrentRoute('create')) {
            $actionButtons->addItem($actionButtons->getDefaultByKey(ShowModeFooterActionBuilder::BTN_CUSTOM_PREV));
            $actionButtons->addItem($actionButtons->getDefaultByKey(ShowModeFooterActionBuilder::BTN_CUSTOM_NEXT));
            $actionButtons->addItem((new ShowModeFooterButtonItem())
                ->setClasses('btn btn-success')
                ->setName(ShowModeFooterActionBuilder::BTN_CUSTOM_REDIRECT)
                ->addIcon('fa-save')
                ->setRouteAction(MarkingAdminController::ROUTER_SHOW)
                ->setTitle('Создать партию и карточки в  Каталоге')
                ,
                );
            $this->setShowModeButtons($actionButtons->getButtonList());
        } else {
            $actionButtons->addItem($actionButtons->getDefaultByKey(ShowModeFooterActionBuilder::BTN_UPDATE_AND_EDIT_AGAIN));
        }

        $this->setShowModeButtons($actionButtons->getButtonList());
    }

    protected function configureDatagridFilters(DatagridMapper $filter)
    {
    }

    public function postPersist($object)
//    public function postUpdate($object)
    {
        /** @var Arrival $object */
        $amount = $object->getAmountCard();

        $groupExplode = function(string $text) {
            return array_map('trim', explode(';', $text));
        };

        $groupPipeSerialNumber = $groupExplode($object->getGroupPipeSerialNumber());
        $groupSerialNoOfNipple = $groupExplode($object->getGroupSerialNoOfNipple());
        $groupCouplingSerialNumber = $groupExplode($object->getGroupCouplingSerialNumber());
        $groupPipeLength = $groupExplode($object->getGroupPipeLength());
        $groupWeightOfPipe = $groupExplode($object->getGroupWeightOfPipe());

        $em = $this->getContainer()->get('doctrine.orm.entity_manager');

        for ($i = 0; $i < $amount; $i++) {
            $card = new Card();

            $card->setArrival($object);

            // Общие значения
            $card->setRefTypeEquipment($object->getRefTypeEquipment());
            $card->setLocation($object->getLocation());
            $card->setOperatingHours($object->getOperatingHours());
            $card->setOuterDiameterOfThePipe($object->getOuterDiameterOfThePipe());
            $card->setPipeWallThickness($object->getPipeWallThickness());
            $card->setRefTypeDisembarkation($object->getRefTypeDisembarkation());
            $card->setRefPipeStrengthGroup($object->getRefPipeStrengthGroup());
            $card->setRefTypeThread($object->getRefTypeThread());
            $card->setOdlockNipple($object->getOdlockNipple());
            $card->setDfchamferNipple($object->getDfchamferNipple());
            $card->setLpcThreadLengthNipple($object->getLpcThreadLengthNipple());
            $card->setNippleNoseDiameter($object->getNippleNoseDiameter());
            $card->setOdlockCoupling($object->getOdlockCoupling());
            $card->setDfchamferCoupling($object->getDfchamferCoupling());
            $card->setLbcThreadLengthCoupler($object->getLbcThreadLengthCoupler());
            $card->setQcBoreDiameterCoupling($object->getQcBoreDiameterCoupling());
            $card->setIdlockNipple($object->getIdlockNipple());
            $card->setShoulderAngle($object->getShoulderAngle());
            $card->setTurnkeyLengthNipple($object->getTurnkeyLengthNipple());
            $card->setTurnkeyLengthCoupling($object->getTurnkeyLengthCoupling());
            $card->setRefThreadCoating($object->getRefThreadCoating());
            $card->setRefInnerCoating($object->getRefInnerCoating());
            $card->setRefHardbandingNipple($object->getRefHardbandingNipple());
            $card->setRefHardbandingCoupling($object->getRefHardbandingCoupling());
            $card->setBtCertificateNumber($object->getBtCertificateNumber());
            $card->setRefWearClass($object->getRefWearClass());

            // Индивидуальные
            $card->setPipeSerialNumber($groupPipeSerialNumber[$i]);
            $card->setSerialNoOfNipple($groupSerialNoOfNipple[$i]);
            $card->setCouplingSerialNumber($groupCouplingSerialNumber[$i]);
            $card->setPipeLength($groupPipeLength[$i]);
            $card->setWeightOfPipe($groupWeightOfPipe[$i]);

            $em->persist($card);
        }

        $em->flush();
    }


}