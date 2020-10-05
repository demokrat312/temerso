<?php

namespace App\Admin;

use App\Classes\Marking\MarkingAccessHelper;
use App\Classes\ShowAdmin\ShowModeFooterActionBuilder;
use App\Classes\ShowAdmin\ShowModeFooterButtonItem;
use App\Classes\Task\TaskAdminParent;
use App\Controller\Admin\ReturnFromRepairAdminController;
use App\Entity\Repair;
use App\Repository\RepairRepository;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\ProxyQueryInterface;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

/**
 * 8 ПРОЦЕСС. ВОЗВРАТ ОБОРУДОВАНИЯ ИЗ РЕМОНТА
 */
class ReturnFromRepairAdmin extends TaskAdminParent
{
    protected function configureRoutes(RouteCollection $collection)
    {
        parent::configureRoutes($collection);
        $collection
            ->add(ReturnFromRepairAdminController::ROUTE_RETURN_FROM_RENT, $this->getRouterIdParameter() . '/' . ReturnFromRepairAdminController::ROUTE_RETURN_FROM_RENT)
            ->add(ReturnFromRepairAdminController::ROUTE_CREATE_INSPECTION, $this->getRouterIdParameter() . '/' . ReturnFromRepairAdminController::ROUTE_CREATE_INSPECTION)
            ->remove('export')
            ->remove('delete')
            ;
    }

    protected function configureQuery(ProxyQueryInterface $query): ProxyQueryInterface
    {
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
                ->addSelect('inspection')
                ->leftJoin(sprintf('%s.%s', $al, 'inspection'), 'inspection')
                ->andWhere($expr->eq('inspection.status', ':statusId'))
                ->setParameter('statusId', $statusId)
            ;
        }

        return $query;

    }

    public function configure()
    {
        $this->setTemplate('edit', 'returnFromRepair/edit.html.twig');
    }

    protected function configureFormFields(FormMapper $editForm)
    {
        $actionButtons = new ShowModeFooterActionBuilder();

        if ($this->isCurrentRoute('create')) {
            $editForm
                ->tab('tab_one', ['label' => 'Главная', 'class' => 'col-md-12'])
                    ->with('')
                        ->add('repair', EntityType::class, [
                            'label' => 'Комплектация в ремонт',
                            'class' => Repair::class,
                            'empty_data' => '',
                            'placeholder' => 'Выберите',
                            'choice_label' => 'choiceTitle',
                            'attr' => ['class' => 'js-on-change-repair'],
                            'query_builder' => function (RepairRepository $er) {
                                return $er->withOutReturnFromRent();
                            },
                        ])
                    ->end()
                ->end();


            $actionButtons->addItem((new ShowModeFooterButtonItem())
                ->setClasses('btn btn-success')
                ->setName(ShowModeFooterActionBuilder::BTN_CUSTOM_REDIRECT)
                ->addIcon('fa-save')
                ->setRouteAction(ReturnFromRepairAdminController::ROUTE_CREATE_INSPECTION)
                ->setTitle('Создать испекцию')
            );
            $actionButtons->addItem((new ShowModeFooterButtonItem())
                ->setClasses('btn btn-warning')
                ->setName(ShowModeFooterActionBuilder::BTN_CUSTOM_REDIRECT)
                ->setRouteAction(ReturnFromRepairAdminController::ROUTE_RETURN_FROM_RENT)
                ->addIcon('fa-save')
                ->setTitle('Вернуть на склад')
                );
        }


        $this->setShowModeButtons($actionButtons->getButtonList());
    }

    protected function configureListFields(ListMapper $list)
    {
        $list
            ->add('taskType')
            ->add('createdBy', null, self::HIDE_LINK_MANY_TO_ONE)
            ->add('repair', null, ['label' => 'Комплектация в ремонт'])
            ->add('statusTitle', null, ['label' => 'Статус'])
            ->add('_action', 'actions',
                array(
                    'label' => 'Инспекция',
                    'actions' => array('usage' => array('template' =>'returnFromRent/listFieldLink.html.twig'))
                )
            )
        ;
    }
}