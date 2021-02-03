<?php

namespace App\Admin;


use App\Classes\Card\CardListFields;
use App\Classes\Card\CardListHelper;
use App\Classes\Card\CardStatusHelper;
use App\Classes\MainAdmin;
use App\Classes\Card\CardFieldsHelper;
use App\Classes\ShowAdmin\ShowModeFooterActionBuilder;
use App\Classes\ShowAdmin\ShowModeFooterButtonItem;
use App\Classes\TopMenuButton\TopMenuButton;
use App\Controller\Admin\CardAdminController;
use App\Entity\Arrival;
use App\Entity\Card;
use App\Entity\Equipment;
use App\Entity\Kit;
use App\Entity\Marking;
use App\Entity\Reference\RefPipeStrengthGroup;
use App\Entity\Reference\RefTypeThread;
use App\Entity\Reference\RefWearClass;
use App\Entity\Repair;
use App\Entity\ReturnFromRepair;
use App\Entity\TaskCardOtherField;
use App\Form\Type\HistoryCallbackFilter;
use App\Repository\EquipmentRepository;
use App\Repository\RepairRepository;
use App\Service\AdminRouteService;
use App\Service\FieldDescriptionService;
use App\Service\Marking\TaskTopMenuButtonService;
use App\Service\TopMenuButtonService;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\PersistentCollection;
use Doctrine\ORM\Query\Expr\Comparison;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\ProxyQueryInterface;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Form\Type\ModelType;
use Sonata\AdminBundle\Route\RouteCollection;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\DoctrineORMAdminBundle\Datagrid\ProxyQuery;
use Sonata\DoctrineORMAdminBundle\Filter\CallbackFilter;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Constraints\Callback;
use Symfony\Component\Validator\Context\ExecutionContextInterface;

/**
 * Created by PhpStorm.
 * User: temerso_test
 * Date: 22.04.2020
 * Time: 20:44
 */
class CardAdmin extends MainAdmin
{
    const ACTION_RESTORE = 'restore';
    const ACTION_DISPOSAL = 'disposal';
    /**
     * @var FieldDescriptionService
     */
    private $fieldDescriptionService;
    /**
     * @var TopMenuButtonService
     */
    private $topMenuButton;
    /**
     * @var AdminRouteService
     */
    private $adminRoute;

    public function __construct(
        $code,
        $class,
        $baseControllerName,
        FieldDescriptionService $fieldDescriptionService,
        TopMenuButtonService $topMenuButton,
        AdminRouteService $adminRoute
    )
    {
        parent::__construct($code, $class, $baseControllerName);
        $this->fieldDescriptionService = $fieldDescriptionService;
        $this->topMenuButton = $topMenuButton;
        $this->adminRoute = $adminRoute;
    }

    public function configure()
    {
        parent::configure();
        $this->classnameLabel = "Card";
    }

    protected function configureDefaultFilterValues(array &$filterValues)
    {
        $filterValues = [
            '_sort_by' => '',
            '_sort_order' => '',
        ];
    }


    /**
     * Фильтруем по статусу
     *
     * @param ProxyQueryInterface $query
     * @return ProxyQueryInterface
     */
    protected function configureQuery(ProxyQueryInterface $query): ProxyQueryInterface
    {
        $query = parent::configureQuery($query);
        $al = $query->getRootAliases()[0];
        /** @var \Doctrine\ORM\Query\Expr $expr */
        $expr = $query->expr();
        /** @var \Doctrine\ORM\QueryBuilder $em */
        $em = $query->getQueryBuilder();

        $em
            ->andWhere($expr->neq(sprintf('%s.%s', $al, 'status'), ':statusId'))
            ->setParameter('statusId', CardStatusHelper::STATUS_BROKEN);


        return $query;
    }

    public function preBatchAction($actionName, ProxyQueryInterface $query, array &$idx, $allElements)
    {
        $actions = parent::getBatchActions();
//        unset($actions['delete']);

        return $actions;
    }

    protected function configureRoutes(RouteCollection $collection)
    {
        parent::configureRoutes($collection);
        $collection
            ->add('history')
            ->add(CardAdminController::ROUTER_DISPOSAL, CardAdminController::ROUTER_DISPOSAL);

        if (CardListHelper::ins()->requestFrom(ReturnFromRepair::class)) {
            $collection->remove('delete');
        }
    }

    /**
     * @param string $action
     * @param null|Marking $object
     * @return array
     * @throws \Exception
     */
    public function configureActionButtons($action, $object = null)
    {
        if ($action !== 'show') return parent::configureActionButtons($action, $object);

        if ($object->getStatus() === CardStatusHelper::STATUS_BROKEN) {
            $this->topMenuButton->addButtonList([
                (new TopMenuButton())->setKey(TopMenuButtonService::BTN_HISTORY),
                (new TopMenuButton())->setKey(TopMenuButtonService::BTN_LIST),
            ]);

            if (in_array('EDIT', $this->getAccess())) {
                $this->topMenuButton->addButton((new TopMenuButton())
                    ->setKey(TaskTopMenuButtonService::BTN_REMOVE_EXECUTOR)
                    ->setTitle('Восстановить карточку')
                    ->setIcon('fa-mail-forward')
                    ->setRoute($this->adminRoute->getActionRouteName(
                        $this->getClass(),
                        'edit',
                        ))
                    ->setRouteParams(['id' => $object->getId(), 'action' => self::ACTION_RESTORE])
                );
            }

        } else {
            $this->topMenuButton->addButtonList([
                (new TopMenuButton())->setKey(TopMenuButtonService::BTN_CREATE),
                (new TopMenuButton())->setKey(TopMenuButtonService::BTN_EDIT),
                (new TopMenuButton())->setKey(TopMenuButtonService::BTN_HISTORY),
                (new TopMenuButton())->setKey(TopMenuButtonService::BTN_LIST),
            ]);

            if (in_array('EDIT', $this->getAccess())) {
                (new TopMenuButton())
                    ->setKey(TaskTopMenuButtonService::BTN_REMOVE_EXECUTOR)
                    ->setTitle('Списать Карточку')
                    ->setIcon('fa-mail-forward')
                    ->setRoute($this->adminRoute->getActionRouteName(
                        $this->getClass(),
                        'edit',
                        ))
                    ->setRouteParams(['id' => $object->getId(), 'action' => self::ACTION_DISPOSAL]);
            }
        }

        return $this->topMenuButton->getList();
    }

    public function getContainer()
    {
        return $this->getConfigurationPool()->getContainer();
    }

    /**
     * {@inheritdoc}
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $getInput = function ($fieldName, $label = null) {
            return $this->fieldDescriptionService
                ->getNewFieldDescriptionInstance(Card::class, $fieldName, ['label' => $label]);
        };


            $showMapper
                ->tab('Номинальные')
                    ->with("left", ['class' => 'col-md-6', 'description' => 'Описание', 'label' => 'Характеристики'])
                        ->add($getInput('outer_diameter_of_the_pipe', 'Наружный диаметр трубы, (мм)'))
                        ->add($getInput('pipe_wall_thickness', 'Толщина стенки трубы, (мм)'))
                        ->add($getInput('ref_type_disembarkation', 'Тип высадки'))
                        ->add($getInput('ref_pipe_strength_group', 'Группа прочности трубы'))
                        ->add($getInput('ref_type_thread', 'Тип резьбы'))
                        ->add($getInput('odlock_nipple', 'O.D. Замка ниппель  (мм)'))
                        ->add($getInput('dfchamfer_nipple', 'D.F.  Фаска ниппель (мм)'))
                        ->add($getInput('lpc_thread_length_nipple', 'LPC   Длина резьбы ниппель (мм)'))
                        ->add($getInput('nipple_nose_diameter', 'Диаметр носика ниппеля'))
                        ->add($getInput('odlock_coupling', 'O.D. Замка муфта  (мм)'))
                        ->add($getInput('dfchamfer_coupling', 'D.F.  Фаска муфта (мм)'))
                        ->add($getInput('lbc_thread_length_coupler', 'LBC Длина резьбы муфта (мм)'))
                    ->end()
                    ->with("right", ['class' => 'col-md-6', 'description' => 'Описание', 'label' => 'Характеристики'])
                        ->add($getInput('qc_bore_diameter_coupling', 'QC Диаметр расточки муфта(мм)'))
                        ->add($getInput('idlock_nipple', 'I.D. Замка ниппель  (мм)'))
                        ->add($getInput('shoulder_angle', 'Угол заплечика (градус)'))
                        ->add($getInput('turnkey_length_nipple', 'Длина под ключ ниппель, (мм)'))
                        ->add($getInput('turnkey_length_coupling', 'Длина под ключ муфта, (мм)'))
                        ->add($getInput('ref_thread_coating', 'Покрытие резьбы'))
                        ->add($getInput('ref_inner_coating', 'Внутреннее покрытие'))
                        ->add($getInput('ref_hardbanding_nipple', 'Хардбендинг (ниппель)'))
                        ->add($getInput('ref_hardbanding_coupling', 'Хардбендинг (муфта)'))
                        ->add($getInput('ref_wear_class', 'Класс износа'))
                        ->add($getInput('pipe_length', 'Длина трубы'))
                        ->add($getInput('weight_of_pipe', 'Вес трубы'))
                    ->end()
                ->end()
                    ->tab('Фактические')
                        ->with("left", ['class' => 'col-md-6', 'description' => 'Описание', 'label' => 'Характеристики'])
                        ->add('id');
                        if($this->getSubject()->getStatus() === CardStatusHelper::STATUS_BROKEN){
                            $showMapper->add('disposalReason', null, ['label' => 'Причина списания']);
                        } else if($this->getSubject()->getRestoreReason()) {
                            $showMapper->add('restoreReason', null, ['label' => 'Причина востановления']);
                        }
                        $showMapper->add('accounting', null, ['label' => 'Учет/Инвентаризация'])
                        ->add('images', null, ['label' => 'Выбрать изображение', 'template' => 'crud/show/file.html.twig'])
                        ->add('files', null, ['label' => 'Файлы', 'template' => 'crud/show/file.html.twig'])
                        ->add('ref_type_equipment', null, ['label' => 'Тип оборудования'])
                        ->add('statusTitle', null, ['label' => 'Статус'])
                        ->add('location', null, ['label' => 'Местоположение'])
                        ->add('operating_hours', null, ['label' => 'Наработка моточасов'])
                        ->add('ref_warehouse', ModelType::class, array_merge(self::HIDE_LINK_MANY_TO_ONE, ['label' => '№ Склада']))
                        ->add('rfid_tag_serial_no', null, ['label' => 'Серийный № метки RFID'])
                        ->add('rfidTagNo', null, ['label' => '№ Метки RFID'])
                        ->add('pipeSerialNumber', null, ['label' => 'Серийный № трубы'])
                        ->add('serialNoOfNipple', null, ['label' => 'Серийный № ниппеля'])
                        ->add('couplingSerialNumber', null, ['label' => 'Серийный № муфты'])
                        ->add('serial_no_after_repair', null, ['label' => 'Серийный № после ремонта'])
                        ->add('outer_diameter_of_the_pipe', null, ['label' => 'Наружный диаметр трубы, (мм)'])
                        ->add('pipe_wall_thickness', null, ['label' => 'Толщина стенки трубы, (мм)'])
                        ->add('ref_type_disembarkation', null, ['label' => 'Тип высадки'])
                        ->add('ref_pipe_strength_group', null, ['label' => 'Группа прочности трубы'])
                        ->add('ref_type_thread', ModelType::class, array_merge(self::HIDE_LINK_MANY_TO_ONE, ['label' => 'Тип резьбы']))
                        ->add('odlock_nipple', null, ['label' => 'O.D. Замка ниппель  (мм)'])
                        ->add('dfchamfer_nipple', null, ['label' => 'D.F.  Фаска ниппель (мм)'])
                        ->add('lpc_thread_length_nipple', null, ['label' => 'LPC   Длина резьбы ниппель (мм)'])
                        ->add('nipple_nose_diameter', null, ['label' => 'Диаметр носика ниппеля'])
                        ->add('odlock_coupling', null, ['label' => 'O.D. Замка муфта  (мм)'])
                        ->add('dfchamfer_coupling', null, ['label' => 'D.F.  Фаска муфта (мм)'])
                        ->add('lbc_thread_length_coupler', null, ['label' => 'LBC Длина резьбы муфта (мм)'])
                        ->add('qc_bore_diameter_coupling', null, ['label' => 'QC Диаметр расточки муфта(мм)'])
                        ->add('idlock_nipple', null, ['label' => 'I.D. Замка ниппель  (мм)'])
                        ->add('pipe_length', null, ['label' => 'Длина трубы (м)'])
                        ->add('weight_of_pipe', null, ['label' => 'Вес трубы (кг)'])
                        ->add('shoulder_angle', null, ['label' => 'Угол заплечика (градус)'])
                        ->add('turnkey_length_nipple', null, ['label' => 'Длина под ключ ниппель, (мм)'])
                        ->add('turnkey_length_coupling', null, ['label' => 'Длина под ключ муфта, (мм)'])
                        ->add('ref_thread_coating', null, ['label' => 'Покрытие резьбы'])
                        ->add('ref_inner_coating', ModelType::class, array_merge(self::HIDE_LINK_MANY_TO_ONE, ['label' => 'Внутреннее покрытие']))
                        ->add('ref_hardbanding_nipple', ModelType::class, array_merge(self::HIDE_LINK_MANY_TO_ONE, ['label' => 'Хардбендинг (ниппель)']))
                        ->add('ref_hardbanding_coupling', ModelType::class, array_merge(self::HIDE_LINK_MANY_TO_ONE, ['label' => 'Хардбендинг (муфта)']))
                    // end left
                    ->end()
                    ->with('right', ['class' => 'col-md-6', 'description' => 'Описание', 'label' => 'Характеристики'])
                    // start right
                        ->add('bt_certificate_number', null, ['label' => 'Номер Сертификата на комплект БТ'])
                        ->add('ref_wear_class', null, ['label' => 'Класс износа'])
                        ->add('ref_visual_control', null, ['label' => 'Визуальный контроль состояния внутреннего покрытия'])
                        ->add('depth_of_naminov', null, ['label' => 'Глубина наминов в зоне работы клиньев max (мм)'])
                        ->add('nipple_end_bend_max', null, ['label' => 'Изгиб ниппельного конца max (мм)'])
                        ->add('coupling_end_bend_max', null, ['label' => 'Изгиб муфтового конца max (мм)'])
                        ->add('the_total_bend_of_the_pipe_body_max', null, ['label' => 'Общий изгиб тела трубы max (мм)'])
                        ->add('ref_ipc_wedge_zone_and_landing_zone', null, ['label' => 'МПК зоны клинев и зоны высадки'])
                        ->add('ref_ultrasonic_testing', null, ['label' => 'УЗК зоны клиньев и зоны высадки'])
                        ->add('ref_emi_body_pipes', null, ['label' => 'EMI тела трубы (багги)'])
                        ->add('ref_pipe_body_class', null, ['label' => 'Класс тела трубы'])
                        ->add('ref_nipple_thread', null, ['label' => 'Контроль шага резьбы ниппеля плоским шаблоном'])
                        ->add('ref_nipple_thread_condition', null, ['label' => 'Состояние резьбы ниппеля'])
                        ->add('ref_state_persistent', null, ['label' => 'Состояние упорных торцев ниппеля'])
                        ->add('ref_ipc_thread_nipple', null, ['label' => 'МПК резьбы ниппеля'])
                        ->add('ref_hardbending_nipple_state', null, ['label' => 'Хардбендинг ниппель (состояние)'])
                        ->add('hardbanding_nipplemm_diameter', null, ['label' => 'Хардбендинг ниппель (диаметр) мм'])
                        ->add('hardbanding_nipple_height', null, ['label' => 'Хардбендинг ниппель (высота наплавки) мм'])
                        ->add('ref_lock_class_nipple', null, ['label' => 'Класс замка ниппель'])
                        ->add('ref_coupling_thread_condition', null, ['label' => 'Состояние резьбы муфты'])
                        ->add('ref_status_coupling_end_faces', null, ['label' => 'Состояние упорных торцев муфты'])
                        ->add('ref_ipc_thread_coupling', null, ['label' => 'МПК резьбы муфты'])
                        ->add('ref_uzk_thread_coupling', null, ['label' => 'УЗК резьбы муфты'])
                        ->add('ref_hardbendig_coupling_state', null, ['label' => 'Хардбендинг муфта (состояние)'])
                        ->add('hardbanding_coupler_diameter', null, ['label' => 'Хардбендинг муфта (диаметр) мм'])
                        ->add('hardbanding_coupling_height_mm', null, ['label' => 'Хардбендинг муфта (высота наплавки) мм'])
                        ->add('lock_class_coupling', null, ['label' => 'Класс замка муфта'])
                        ->add('min_the_width_thrust_shoulder', null, ['label' => 'Миним. ширина упорного уступа ниппеля при эксцентрич износе мм'])
                        ->add('min_width_stop_shoulder', null, ['label' => 'Миним. ширина упорного уступа муфты при эксцентрич износе мм'])
                        ->add('min_length_transition_section', null, ['label' => 'Миним. Длина переходного участка высадки miu,  мм'])
                        ->add('ref_label_resurfacing', null, ['label' => 'Метка для перешлифовки'])
                        ->add('the_minimum_moment', null, ['label' => 'Минимальный момент свинчивания замка, кНм'])
                        ->add('the_maximum_moment', null, ['label' => 'Максимальный момент свинчивания замка, кНм'])
                        ->add('the_limiting_moment', null, ['label' => 'Предельный  момент кручения  замка, кНм'])
                        ->add('the_ultimate_tensile', null, ['label' => 'Предельная растягивающая нагрузка замка, Кн'])
                        ->add('the_ultimate_torque_of_the_tube', null, ['label' => 'Предельный  момент кручения  трубы, кНм'])
                        ->add('the_ultimate_tensile_load_of_the_pipe', null, ['label' => 'Предельная растягивающая нагрузка трубы, Кн'])
                    ->end()
                        ->with('fields', ['class' => 'col-md-12', 'label' => 'Дополнительные поля'])
                            ->add('cardFields', null, ['label' => 'empty', 'template' => '/viewList/cardFields.html.twig'])
                        ->end()
                        ->with('taskCardOtherFields', ['class' => 'col-md-12', 'label' => 'Поля связанные с задачами'])
                            ->add('taskCardOtherFields', null, ['label' => 'empty', 'template' => '/viewList/cardTaskOtherField.html.twig'])
                        ->end()
                        ->with('operationTimeCounter', ['class' => 'col-md-12', 'label' => 'Счетчик по наработке'])
                            ->add('operationTimeCounter', CollectionType::class, ['label' => 'empty', 'template' => '/viewList/operationTimeCounter.html.twig'])
                        ->end()
                ->end()
            ;
    }

    /**
     * {@inheritdoc}
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        parent::configureListFields($listMapper);

        CardListFields::ins()->getFields($listMapper, $this->getAccess());

    }

    /**
     * {@inheritdoc}
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('outer_diameter_of_the_pipe', HistoryCallbackFilter::class, ['label' => 'Наружный диаметр трубы, (мм)', 'advanced_filter' => true])
            ->add('odlock_nipple', HistoryCallbackFilter::class, ['label' => 'O.D. Замка ниппель  (мм)'])
            ->add('ref_pipe_strength_group', HistoryCallbackFilter::class, [
                'field_type' => EntityType::class,
                'field_options' => ['class' => RefPipeStrengthGroup::class],
                'label' => 'Группа прочности трубы',
            ])
            ->add('shoulder_angle', HistoryCallbackFilter::class, ['label' => 'Угол заплечика (градус)'])
            ->add('pipe_length', HistoryCallbackFilter::class, ['label' => 'Длина трубы (м)'])
            ->add('ref_type_thread', HistoryCallbackFilter::class, [
                'field_type' => EntityType::class,
                'field_options' => ['class' => RefTypeThread::class],
                'label' => 'Тип резьбы'
            ])
            ->add('ref_wear_class', HistoryCallbackFilter::class, [
                'field_type' => EntityType::class,
                'field_options' => ['class' => RefWearClass::class],
                'label' => 'Класс износа'
            ])
            ->add('consignment', CallbackFilter::class, [
                'label' => 'Партия',
                'field_type' => EntityType::class,
                'field_options' => [
                    'class' => Arrival::class,
                    'choice_label' => 'choiceTitle',
                    'query_builder' => function (EntityRepository $er) {
                        return $er->createQueryBuilder('consignment')
                            ->orderBy('consignment.id', 'DESC');
                    },
                ],
                'callback' => function (ProxyQuery $queryBuilder, $alias, $field, $value) {
                    if (!$value['value']) {
                        return false;
                    }

                    $qb = $queryBuilder;
                    $qb
//                        ->leftJoin('\App\Entity\EquipmentKit', 'kit')
                        ->leftJoin(sprintf('%s.arrival', $alias), 'arrival')
                        ->andWhere($qb->expr()->eq('arrival.id', '?1'),)
                        ->setParameter('1', $value['value']);

                    return true;
                },
            ])
            ->add('rend', CallbackFilter::class, [
                'label' => 'По комплектам в аренде',
                'field_type' => EntityType::class,
                'field_options' => [
                    'class' => Equipment::class,
                    'choice_label' => 'choiceTitle',
                    'query_builder' => function (EquipmentRepository $er) {
                        return $er->withOutReturnFromRent();
                    },
                ],
                'callback' => function (ProxyQuery $queryBuilder, $alias, $field, $value) {
                    if (!$value['value']) {
                        return false;
                    }

                    $qb = $queryBuilder;
                    $qb
                        ->leftJoin(sprintf('%s.equipmentKit', $alias), 'equipmentKit')
                        ->leftJoin('equipmentKit.equipment', 'equipment')
                        ->andWhere($qb->expr()->eq('equipment.id', '?1'),)
                        ->setParameter('1', $value['value']);

                    return true;
                },
            ])
            ->add('repair', CallbackFilter::class, [
                'label' => 'По комплектам в ремонте',
                'field_type' => EntityType::class,
                'field_options' => [
                    'class' => Repair::class,
                    'choice_label' => 'choiceTitle',
                    'query_builder' => function (RepairRepository $er) {
                        return $er->withOutReturnFromRepair();
                    },
                ],
                'callback' => function (ProxyQuery $queryBuilder, $alias, $field, $value) {
                    if (!$value['value']) {
                        return false;
                    }

                    $qb = $queryBuilder;
                    $qb
                        ->leftJoin(sprintf('%s.repair', $alias), 'repair')
                        ->andWhere($qb->expr()->eq('repair.id', '?1'),)
                        ->setParameter('1', $value['value']);

                    return true;
                },
            ])
            ->add('broken', CallbackFilter::class, [
                'label' => 'Списанное оборудование',
                'mapped' => false,
                'field_type' => CheckboxType::class,
                'callback' => function (ProxyQuery $queryBuilder, $alias, $field, $value) {
                    if (!$value['value']) {
                        return false;
                    }

                    $qb = $queryBuilder;
                    $parts = $qb->getDQLPart('where')->getParts();
                    $qb->resetDQLPart('where');
                    foreach ($parts as $key => $part) {
                        if ($part instanceof Comparison && $part->getLeftExpr() === $alias . '.status') {
                            unset($parts[$key]);
                            /** @var \Doctrine\ORM\Query\Parameter[] $parameters */
                            $parameters = $qb->getParameters();
                            foreach ($parameters as $key => $parameter) {
                                if ($parameter->getName() === 'statusId') {
                                    unset($parameters[$key]);
                                }
                            }
                            $qb->setParameters($parameters);
                        }
                    }
                    $qb
                        ->andWhere($qb->expr()->eq(sprintf('%s.status', $alias), '?1'),)
                        ->setParameter('1', CardStatusHelper::STATUS_BROKEN);

                    return true;
                },
            ])
            ->add('kit', CallbackFilter::class, [
                'label' => 'Комплект для постановщика',
                'mapped' => false,
                'field_type' => EntityType::class,
                'field_options' => [
                    'class' => Kit::class,
                    'choice_label' => 'choiceTitle',
                ],
                'callback' => function (ProxyQuery $queryBuilder, $alias, $field, $value) {
                    if (!$value['value']) {
                        return false;
                    }

                    $qb = $queryBuilder;
                    $qb
                        ->orderBy('kitCardOrder.orderNumber', 'ASC')
                        ->join(sprintf('%s.kitCardOrder', $alias), 'kitCardOrder')
                        ->join('kitCardOrder.kit', 'kit')
                        ->andWhere($qb->expr()->eq('kit.id', '?1'),)
                        ->setParameter('1', $value['value']);


                    return true;
                },
            ])
//            ->add('pipeSerialNumber', \Sonata\DoctrineORMAdminBundle\Filter\ModelAutocompleteFilter::class, [], null, ['property' => 'pipeSerialNumber'])
            ->add('pipeSerialNumber', null, ['label' => 'Серийный № трубы'])
        ;
    }

    /**
     * {@inheritdoc}
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        if ($this->request->getMethod() === 'POST') {
            $form = $this->request->get($this->getUniqid());
            $action = $form['action'] ?? null;
        } else if ($this->getSubject()->getStatus() === CardStatusHelper::STATUS_BROKEN) {
            $action = self::ACTION_RESTORE;
        } else {
            $action = $this->request->query->get('action');
        }


        if (CardListHelper::ins()->requestFrom(ReturnFromRepair::class)) {
            $formMapper->add('images', \Sonata\AdminBundle\Form\Type\CollectionType::class, array(
                'entry_type' => \App\Classes\Type\MediaType::class,
                'label' => 'Выбрать изображение',
                'entry_options' => array(
                    'provider' => 'sonata.media.provider.image',
                    'context' => 'card_return_form_rent',
                    'empty_on_new' => false,
                    'new_on_update' => false,
                ),
                'allow_add' => true,
                'by_reference' => false,
                'allow_delete' => true,
            ));
        } else if ($action) {
            if ($action === self::ACTION_DISPOSAL) {
                $fileOrImageEmptyCounter = 0;
                $fileOrImageConstraints = function ($object, ExecutionContextInterface $context) use (&$fileOrImageEmptyCounter) {
                    /** @var $object \Doctrine\Common\Collections\ArrayCollection|PersistentCollection */
                    if ($object->count() === 0) {
                        $fileOrImageEmptyCounter++;
                        if ($fileOrImageEmptyCounter >= 2) {
                            $context->addViolation('Нужно добавить хотя бы одно изображение или файл');
                        }
                    }

                };
                $formMapper
                    ->with("disposal", ['class' => 'col-md-12',  'label' => 'Списать Карточку'])
                        ->add('status', HiddenType::class, ['data' => CardStatusHelper::STATUS_BROKEN])
                        ->add('action', HiddenType::class, ['data' => self::ACTION_DISPOSAL, 'mapped' => false])
                        ->add('disposalReason', TextareaType::class, ['label' => 'Причина списания'])
                        ->add('images', \Sonata\AdminBundle\Form\Type\CollectionType::class, array(
                            'required' => true,
                            'entry_type' => \App\Classes\Type\MediaType::class,
                            'label' => 'Выбрать изображение',
                            'entry_options' => array(
                                'provider' => 'sonata.media.provider.image',
                                'context' => 'card_disposal',
                                'empty_on_new' => false,
                                'new_on_update' => false,
                            ),
                            'allow_add' => true,
                            'by_reference' => false,
                            'allow_delete' => true,
                            'constraints' => [
//                                new Assert\Count([
//                                    'min' => 1,
//                                    'minMessage' => 'Хотя бы одна фотография',
//                                ]),
                                new CallBack($fileOrImageConstraints)
                            ],
                        ))
                        ->add('files', \Sonata\AdminBundle\Form\Type\CollectionType::class, array(
                            'required' => true,
                            'entry_type' => \Sonata\MediaBundle\Form\Type\MediaType::class,
                            'label' => 'Файлы',
                            'entry_options' => array(
                                'provider' => 'sonata.media.provider.file',
                                'context' => 'card_disposal',
                                'empty_on_new' => false,
                                'new_on_update' => false,
                            ),
                            'allow_add' => true,
                            'by_reference' => false,
                            'allow_delete' => true,
                            'constraints' => [
//                                new Assert\Count([
//                                    'min' => 1,
//                                    'minMessage' => 'Хотя бы один файл',
//                                    // also has max and maxMessage just like the Length constraint
//                                ]),
                                new CallBack($fileOrImageConstraints)
                            ],
                        ))
                    ->end();

                $actionButtons = new ShowModeFooterActionBuilder();

                $actionButtons->addItem((new ShowModeFooterButtonItem())
                    ->setClasses('btn btn-warning')
                    ->setName(ShowModeFooterActionBuilder::BTN_UPDATE_AND_LIST)
                    ->addIcon('fa-save')
                    ->setTitle('Списать Карточку')
                    ,
                    );

                $this->setShowModeButtons($actionButtons->getButtonList());
            } else if ($action === self::ACTION_RESTORE) {
                $formMapper
                    ->with("restore", ['class' => 'col-md-12', 'label' => 'Восстановить карточку'])
                        ->add('status', HiddenType::class, ['data' => CardStatusHelper::STATUS_STORE])
                        ->add('action', HiddenType::class, ['data' => self::ACTION_RESTORE, 'mapped' => false])
                        ->add('restoreReason', TextareaType::class, ['label' => 'Причина востановления'])
                    ->end();

                $actionButtons = new ShowModeFooterActionBuilder();

                $actionButtons->addItem((new ShowModeFooterButtonItem())
                    ->setClasses('btn btn-success')
                    ->setName(ShowModeFooterActionBuilder::BTN_CUSTOM_REDIRECT)
                    ->setRouteAction(CardAdminController::ROUTER_DISPOSAL)
                    ->addIcon('fa-save')
                    ->setTitle('Восстановить карточку')
                    ,
                    );

                $this->setShowModeButtons($actionButtons->getButtonList());
            }
        } else {
            $formMapper
                ->tab('general', ['label' => 'Главная'])
                ->with("left", ['class' => 'col-md-6', 'description' => 'Описание', 'label' => 'Характеристики'])
                ->add('accounting', null, ['label' => 'Учет/Инвентаризация'])
                ->add('ref_type_equipment', null, ['label' => 'Тип оборудования'])
                ->add('location', null, ['label' => 'Местоположение'])
                ->add('operating_hours', null, ['label' => 'Наработка моточасов'])
                ->add('ref_warehouse', ModelType::class, ['label' => '№ Склада'])
                ->add('rfid_tag_serial_no', null, ['label' => 'Серийный № метки RFID'])
                ->add('rfidTagNo', null, ['label' => '№ Метки RFID'])
                ->add('pipeSerialNumber', null, ['label' => 'Серийный № трубы'])
                ->add('serialNoOfNipple', null, ['label' => 'Серийный № ниппеля'])
                ->add('couplingSerialNumber', null, ['label' => 'Серийный № муфты'])
                ->add('serial_no_after_repair', null, ['label' => 'Серийный № после ремонта'])
                ->add('outer_diameter_of_the_pipe', null, ['label' => 'Наружный диаметр трубы, (мм)'])
                ->add('pipe_wall_thickness', null, ['label' => 'Толщина стенки трубы, (мм)'])
                ->add('ref_type_disembarkation', null, ['label' => 'Тип высадки'])
                ->add('ref_pipe_strength_group', null, ['label' => 'Группа прочности трубы'])
                ->add('ref_type_thread', ModelType::class, ['label' => 'Тип резьбы'])
                ->add('odlock_nipple', null, ['label' => 'O.D. Замка ниппель  (мм)'])
                ->add('dfchamfer_nipple', null, ['label' => 'D.F.  Фаска ниппель (мм)'])
                ->add('lpc_thread_length_nipple', null, ['label' => 'LPC   Длина резьбы ниппель (мм)'])
                ->add('nipple_nose_diameter', null, ['label' => 'Диаметр носика ниппеля'])
                ->add('odlock_coupling', null, ['label' => 'O.D. Замка муфта  (мм)'])
                ->add('dfchamfer_coupling', null, ['label' => 'D.F.  Фаска муфта (мм)'])
                ->add('lbc_thread_length_coupler', null, ['label' => 'LBC Длина резьбы муфта (мм)'])
                ->add('qc_bore_diameter_coupling', null, ['label' => 'QC Диаметр расточки муфта(мм)'])
                ->add('idlock_nipple', null, ['label' => 'I.D. Замка ниппель  (мм)'])
                ->add('pipe_length', null, ['label' => 'Длина трубы (м)'])
                ->add('weight_of_pipe', null, ['label' => 'Вес трубы (кг)'])
                ->add('shoulder_angle', null, ['label' => 'Угол заплечика (градус)'])
                ->add('turnkey_length_nipple', null, ['label' => 'Длина под ключ ниппель, (мм)'])
                ->add('turnkey_length_coupling', null, ['label' => 'Длина под ключ муфта, (мм)'])
                ->add('ref_thread_coating', null, ['label' => 'Покрытие резьбы'])
                ->add('ref_inner_coating', ModelType::class, ['label' => 'Внутреннее покрытие'])
                ->add('ref_hardbanding_nipple', ModelType::class, ['label' => 'Хардбендинг (ниппель)'])
                ->add('ref_hardbanding_coupling', ModelType::class, ['label' => 'Хардбендинг (муфта)'])
                // end left
                ->end()->with('right', ['class' => 'col-md-6', 'description' => 'Описание', 'label' => 'Характеристики'])
                // start right
                ->add('bt_certificate_number', null, ['label' => 'Номер Сертификата на комплект БТ'])
                ->add('ref_wear_class', null, ['label' => 'Класс износа'])
                ->add('ref_visual_control', null, ['label' => 'Визуальный контроль состояния внутреннего покрытия'])
                ->add('depth_of_naminov', null, ['label' => 'Глубина наминов в зоне работы клиньев max (мм)'])
                ->add('nipple_end_bend_max', null, ['label' => 'Изгиб ниппельного конца max (мм)'])
                ->add('coupling_end_bend_max', null, ['label' => 'Изгиб муфтового конца max (мм)'])
                ->add('the_total_bend_of_the_pipe_body_max', null, ['label' => 'Общий изгиб тела трубы max (мм)'])
                ->add('ref_ipc_wedge_zone_and_landing_zone', null, ['label' => 'МПК зоны клинев и зоны высадки'])
                ->add('ref_ultrasonic_testing', null, ['label' => 'УЗК зоны клиньев и зоны высадки'])
                ->add('ref_emi_body_pipes', null, ['label' => 'EMI тела трубы (багги)'])
                ->add('ref_pipe_body_class', null, ['label' => 'Класс тела трубы'])
                ->add('ref_nipple_thread', null, ['label' => 'Контроль шага резьбы ниппеля плоским шаблоном'])
                ->add('ref_nipple_thread_condition', null, ['label' => 'Состояние резьбы ниппеля'])
                ->add('ref_state_persistent', null, ['label' => 'Состояние упорных торцев ниппеля'])
                ->add('ref_ipc_thread_nipple', null, ['label' => 'МПК резьбы ниппеля'])
                ->add('ref_hardbending_nipple_state', null, ['label' => 'Хардбендинг ниппель (состояние)'])
                ->add('hardbanding_nipplemm_diameter', null, ['label' => 'Хардбендинг ниппель (диаметр) мм'])
                ->add('hardbanding_nipple_height', null, ['label' => 'Хардбендинг ниппель (высота наплавки) мм'])
                ->add('ref_lock_class_nipple', null, ['label' => 'Класс замка ниппель'])
                ->add('ref_coupling_thread_condition', null, ['label' => 'Состояние резьбы муфты'])
                ->add('ref_status_coupling_end_faces', null, ['label' => 'Состояние упорных торцев муфты'])
                ->add('ref_ipc_thread_coupling', null, ['label' => 'МПК резьбы муфты'])
                ->add('ref_uzk_thread_coupling', null, ['label' => 'УЗК резьбы муфты'])
                ->add('ref_hardbendig_coupling_state', null, ['label' => 'Хардбендинг муфта (состояние)'])
                ->add('hardbanding_coupler_diameter', null, ['label' => 'Хардбендинг муфта (диаметр) мм'])
                ->add('hardbanding_coupling_height_mm', null, ['label' => 'Хардбендинг муфта (высота наплавки) мм'])
                ->add('lock_class_coupling', null, ['label' => 'Класс замка муфта'])
                ->add('min_the_width_thrust_shoulder', null, ['label' => 'Миним. ширина упорного уступа ниппеля при эксцентрич износе мм'])
                ->add('min_width_stop_shoulder', null, ['label' => 'Миним. ширина упорного уступа муфты при эксцентрич износе мм'])
                ->add('min_length_transition_section', null, ['label' => 'Миним. Длина переходного участка высадки miu,  мм'])
                ->add('ref_label_resurfacing', null, ['label' => 'Метка для перешлифовки'])
                ->add('the_minimum_moment', null, ['label' => 'Минимальный момент свинчивания замка, кНм'])
                ->add('the_maximum_moment', null, ['label' => 'Максимальный момент свинчивания замка, кНм'])
                ->add('the_limiting_moment', null, ['label' => 'Предельный  момент кручения  замка, кНм'])
                ->add('the_ultimate_tensile', null, ['label' => 'Предельная растягивающая нагрузка замка, Кн'])
                ->add('the_ultimate_torque_of_the_tube', null, ['label' => 'Предельный  момент кручения  трубы, кНм'])
                ->add('the_ultimate_tensile_load_of_the_pipe', null, ['label' => 'Предельная растягивающая нагрузка трубы, Кн'])
                ->end()->end()->tab('media', ['label' => 'Медиа'])->with('media', ['label' => 'Медиа'])
                // \Symfony\Component\Form\Extension\Core\Type\CollectionType
                // \Sonata\Form\Type\CollectionType
                // \Sonata\CoreBundle\Form\Type\CollectionType
                // \Sonata\AdminBundle\Form\Type\CollectionType
                ->add('images', \Sonata\AdminBundle\Form\Type\CollectionType::class, array(
                    'entry_type' => \App\Classes\Type\MediaType::class,
                    'label' => 'Выбрать изображение',
                    'entry_options' => array(
                        'provider' => 'sonata.media.provider.image',
                        'context' => 'card',
                        'empty_on_new' => false,
                        'new_on_update' => false,
                    ),
                    'allow_add' => true,
                    'by_reference' => false,
                    'allow_delete' => true,
                ))
                ->add('files', \Sonata\AdminBundle\Form\Type\CollectionType::class, array(
                    'entry_type' => \Sonata\MediaBundle\Form\Type\MediaType::class,
                    'label' => 'Файлы',
                    'entry_options' => array(
                        'provider' => 'sonata.media.provider.file',
                        'context' => 'card',
                        'empty_on_new' => false,
                        'new_on_update' => false,
                    ),
                    'allow_add' => true,
                    'by_reference' => false,
                    'allow_delete' => true,
                ))
//            ->add('media', \Sonata\Form\Type\CollectionType::class, [
//                'type_options' => [
//                    // Prevents the "Delete" option from being displayed
//                    'delete' => false,
//                    'delete_options' => [
//                        // You may otherwise choose to put the field but hide it
//                        'type'         => HiddenType::class,
//                        // In that case, you need to fill in the options as well
//                        'type_options' => [
//                            'mapped'   => false,
//                            'required' => false,
//                        ]
//                    ]
//                ]
//            ], [
//                'link_parameters' => array(
//                    'context' => 'card',
//                ),
//                'btn_add' => 'add',
//                'edit' => 'inline',
//                'inline' => 'table',
//                'sortable' => 'position',
////                'admin_code' => 'sonata.media.admin.media',
//            ])
//                ->add('media', ModelListType::class, [], [
//                'link_parameters' => [
//                    'context' => 'card',
//                    'hide_context' => true,
//                    'mode' => 'tree','multiple' => true,
//                ],
//            ])
                ->end()->end()
            ;

            $fieldsHelper = new CardFieldsHelper($this->getContainer()->get('doctrine.orm.entity_manager'));

            /** @var Card $card */
            $card = $this->getSubject();
            $fieldsHelper->addToForm($formMapper, $card);
        }
    }
}