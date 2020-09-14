<?php

namespace App\Classes\Task;

use App\Classes\MainAdmin;
use App\Classes\Marking\MarkingAccessHelper;
use App\Service\Marking\TaskTopMenuButtonService;
use App\Classes\ShowAdmin\ShowModeFooterActionBuilder;
use App\Classes\ShowAdmin\ShowModeFooterButtonItem;
use App\Controller\Admin\MarkingAdminController;
use App\Entity\Card;
use App\Entity\Marking;
use App\Form\Type\AdminListType;
use App\Service\Access\RoleService;
use Doctrine\ORM\EntityManagerInterface;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\ProxyQueryInterface;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use Sonata\AdminBundle\Show\ShowMapper;
use Symfony\Component\Security\Core\Security;

/**
 * Задачи
 */
abstract class TaskAdminParent extends MainAdmin
{
    /**
     * @var Security
     */
    protected $security;
    /**
     * @var RoleService
     */
    private $roleService;
    /**
     * @var TaskTopMenuButtonService
     */
    private $taskTopMenuButtonService;

    public function __construct(
        $code,
        $class,
        $baseControllerName,
        Security $security,
        RoleService $roleService,
        TaskTopMenuButtonService $markingTopMenuButtonService
    )
    {
        parent::__construct($code, $class, $baseControllerName);
        $this->security = $security;
        $this->roleService = $roleService;
        $this->taskTopMenuButtonService = $markingTopMenuButtonService;
    }

    /**
     * @return EntityManagerInterface|null
     */
    public function getEntityManager()
    {
        return $this->getConfigurationPool()->getContainer()->get('doctrine.orm.entity_manager');
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

        $statusId = (int)$this->request->get('status');
        if(!$statusId) {
            $filter = $this->request->get('filter');
            $statusId = $filter && isset($filter['status']) ?  $filter['status'] : null;
        }


        if($statusId) {
            $em
                ->andWhere($expr->eq(sprintf('%s.%s', $al, 'status'), ':statusId'))
                ->setParameter('statusId', $statusId)
            ;
        }

        $em->setParameter('userId', $this->security->getToken()->getUser()->getId());

        // По доступам для постановщика(адимина)
        $creatorExpr = $expr->andX(
            $expr->eq(sprintf('%s.%s', $al, 'createdBy'), ':userId'),
            $expr->in(sprintf('%s.%s', $al, 'status'), ':createdByStatusIds')
        );
        $em
            ->setParameter('createdByStatusIds', MarkingAccessHelper::getShowStatusAccessWeb(MarkingAccessHelper::USER_TYPE_CREATOR));

        // По доступам для исполнителя(кладовщик)
        $em->leftJoin(sprintf('%s.%s', $al, 'users'), 'users');
        $executorExpr = $expr->andX(
            $expr->eq('users.id', ':userId'),
            $expr->in(sprintf('%s.%s', $al, 'status'), ':executorStatusIds')
        );
        $em
            ->setParameter('executorStatusIds', MarkingAccessHelper::getShowStatusAccessWeb(MarkingAccessHelper::USER_TYPE_EXECUTOR));

        $em->andWhere($expr->orX($creatorExpr, $executorExpr));
        $em->orderBy(sprintf('%s.%s', $al, 'id'), 'ASC');
        return $query;
    }

    protected function configureRoutes(RouteCollection $collection)
    {
        $collection
            ->add(MarkingAdminController::ROUTER_CHANGE_STATUS, $this->getRouterIdParameter() . '/change-status')
            ->add(MarkingAdminController::ROUTER_REMOVE_EXECUTOR, $this->getRouterIdParameter() . '/remove-executor')
            ->add('excel', $this->getRouterIdParameter().'/excel')
            ->remove('export')
            ->remove('acl')
        ;

    }

    /**
     * @param string $action
     * @param null|Marking $object
     * @return array
     * @throws \Exception
     */
    public function configureActionButtons($action, $object = null)
    {
        return $this->taskTopMenuButtonService
            ->setObject($object)
            ->setEntityClass($this->getClass())
            ->build(
                $this->roleService->getRole(),
                $object ? $object->getStatus() : null,
                $action
            );
    }

    protected function configureListFields(ListMapper $list)
    {
        $list
            ->add('taskType', null, self::VIEW_LINK)
            ->add('createdBy', null, self::VIEW_LINK)
            ->add('executor')
            ->add('createAt')
            ->add('statusTitle', null,['label' => 'Статус',])
        ;
    }

    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->with('general', ['label' => 'Главная', 'class' => 'col-md-12'])
                ->add('comment')
                ->add('users')
                ->add('cards')
            ->end();
    }

    protected function configureFormFields(FormMapper $editForm)
    {
        $editForm
            ->with('general', ['label' => 'Главная', 'class' => 'col-md-12'])
                ->add('comment')
                ->add('cards', AdminListType::class, [
                    'class' => Card::class,
                    'field_show_name' => 'generalName',
                    'multiple' => true,
                    'label' => 'Карточки',
                ])
                ->add('users', \Sonata\AdminBundle\Form\Type\ModelType::class, [
                    'property' => 'fio',
                    'multiple' => true,
                    'label' => 'Исполнители',
                    'btn_add' => false
                ])
            ->end();


        $actionButtons = new ShowModeFooterActionBuilder();

        if ($this->isCurrentRoute('create')) {
            $actionButtons->addItem($actionButtons->getDefaultByKey(ShowModeFooterActionBuilder::BTN_CREATE_AND_EDIT));
        } else {
            $actionButtons->addItem($actionButtons->getDefaultByKey(ShowModeFooterActionBuilder::BTN_UPDATE_AND_EDIT_AGAIN));
        }

        $actionButtons->addItem((new ShowModeFooterButtonItem())
            ->setClasses('btn btn-success')
            ->setName(ShowModeFooterActionBuilder::BTN_CUSTOM_REDIRECT)
            ->addIcon('fa-save')
            ->setRouteAction(MarkingAdminController::ROUTER_CHANGE_STATUS)
            ->setRouteQuery(http_build_query(['status' => Marking::STATUS_SEND_EXECUTION]))
            ->setTitle('Отправить на исполнение')
            ,
            );

        $this->setShowModeButtons($actionButtons->getButtonList());
    }
}