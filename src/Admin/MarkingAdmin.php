<?php

namespace App\Admin;

use App\Classes\MainAdmin;
use App\Service\Marking\MarkingTopMenuButtonService;
use App\Classes\ShowAdmin\ShowModeFooterActionBuilder;
use App\Classes\ShowAdmin\ShowModeFooterButtonItem;
use App\Controller\Admin\MarkingAdminController;
use App\Entity\Card;
use App\Entity\Marking;
use App\Entity\User;
use App\Form\Type\AdminListType;
use App\Service\Access\RoleService;
use App\Service\TopMenuButtonService;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\ProxyQueryInterface;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use Sonata\AdminBundle\Show\ShowMapper;
use Symfony\Component\Security\Core\Security;

/**
 * Маркировка
 */
class MarkingAdmin extends MainAdmin
{
    /**
     * @var Security
     */
    private $security;
    /**
     * @var TopMenuButtonService
     */
    private $actionButtonService;
    /**
     * @var RoleService
     */
    private $roleService;
    /**
     * @var MarkingTopMenuButtonService
     */
    private $markingTopMenuButtonService;

    public function __construct(
        $code,
        $class,
        $baseControllerName,
        Security $security,
        RoleService $roleService,
        MarkingTopMenuButtonService $markingTopMenuButtonService
    )
    {
        parent::__construct($code, $class, $baseControllerName);
        $this->security = $security;
        $this->roleService = $roleService;
        $this->markingTopMenuButtonService = $markingTopMenuButtonService;
    }

    protected function configureQuery(ProxyQueryInterface $query): ProxyQueryInterface
    {
        $query = parent::configureQuery($query);
        if ($this->security->isGranted([User::ROLE_INSPECTOR, User::ROLE_STOREKEEPER])) {
            $al = $query->getRootAliases()[0];
            /** @var \Doctrine\ORM\Query\Expr $expr */
            $expr = $query->expr();
            /** @var \Doctrine\ORM\QueryBuilder $em */
            $em = $query->getQueryBuilder();

            $em
                ->leftJoin($al . '.users', 'user')
                ->andWhere($expr->andX(
                    $expr->eq(sprintf('%s.%s', 'user', 'id'), ':userId'),
                    $expr->in(sprintf('%s.%s', $al, 'status'), ':statusIds')
                ));

            $query
                ->setParameter('userId', $this->security->getUser()->getId())
                ->setParameter('statusIds', [Marking::STATUS_SEND_EXECUTION, Marking::STATUS_ACCEPT_EXECUTION]);
        }
        return $query;
    }

    protected function configureRoutes(RouteCollection $collection)
    {
        $collection
            ->add(MarkingAdminController::ROUTER_CHANGE_STATUS, $this->getRouterIdParameter() . '/change-status')
            ->add(MarkingAdminController::ROUTER_REMOVE_EXECUTOR, $this->getRouterIdParameter() . '/remove-executor')
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
        return $this->markingTopMenuButtonService
            ->setObject($object)
            ->build(
                $this->roleService->getRole(),
                $object ? $object->getStatus() : null,
                $action
            );
    }


    protected function configureListFields(ListMapper $list)
    {
        $list->addIdentifier('id');
    }

    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->with('general', ['label' => 'Главная', 'class' => 'col-md-12'])
            ->add('users')
            ->add('cards')
            ->end();
    }

    protected function configureFormFields(FormMapper $editForm)
    {
        $editForm
            ->with('general', ['label' => 'Главная', 'class' => 'col-md-12'])
            ->add('cards', AdminListType::class, [
                'class' => Card::class,
                'field_show_name' => 'generalName',
                'multiple' => true,
                'label' => 'Карточки',
            ])
//            ->add('users', \Sonata\AdminBundle\Form\Type\ModelAutocompleteType::class, [
//                'property' => 'all',
//                'multiple' => true,
//                'label' => 'Исполнители',
//            ])
            ->add('users', \Sonata\AdminBundle\Form\Type\ModelType::class, [
                'property' => 'fio',
                'multiple' => true,
                'label' => 'Исполнители',
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