<?php
/**
 * Created by PhpStorm.
 * User: temerso_test
 * Date: 28.05.2020
 * Time: 18:52
 */

namespace App\Service\Marking;


use App\Classes\TopMenuButton\TopMenuAccess;
use App\Classes\TopMenuButton\TopMenuButton;
use App\Controller\Admin\MarkingAdminController;
use App\Entity\Marking;
use App\Entity\User;
use App\Service\AdminRouteService;
use App\Service\TopMenuButtonService;

class MarkingTopMenuButtonService
{
    const BTN_SEND_EXECUTION = 'btn_send_execution'; // Отправить на исполнение
    const BTN_REMOVE_EXECUTOR = 'btn_remove_executor'; // Снять исполнителя
    const BTN_ACCEPT_EXECUTION = 'btn_accept_execution'; // Принять на исполнение
    const BTN_SEND_REVIEW = 'btn_send_review'; // Отправить задание на проверку
    const BTN_REVIEW_SUCCESS = 'btn_review_success'; // Принять от Исполнителя
    const BTN_REVIEW_ERROR = 'btn_review_error'; // Отклонить/отправить на доработку

    /**
     * @var array |TopMenuAccess[]
     */
    private $accessList = [
//        ['role' => USER::ROLE_ADMIN, 'status' => Marking::STATUS_CREATED, 'mode' => TopActionButtonService::MODE_SHOW, 'buttons' => [
//            TopActionButtonService::BTN_CREATE, TopActionButtonService::BTN_EDIT, TopActionButtonService::BTN_LIST,
//        ]],
//        ['role' => USER::ROLE_ADMIN, 'status' => [Marking::STATUS_SEND_EXECUTION, Marking::STATUS_ACCEPT_EXECUTION], 'mode' => TopActionButtonService::MODE_SHOW, 'buttons' => [
//            TopActionButtonService::BTN_CREATE, TopActionButtonService::BTN_LIST, self::BTN_REMOVE_EXECUTOR,
//        ]],
//        ['role' => USER::ROLE_INSPECTOR, 'status' => [Marking::STATUS_SEND_EXECUTION], 'mode' => TopActionButtonService::MODE_SHOW, 'buttons' => [
//            TopActionButtonService::BTN_LIST, self::BTN_ACCEPT_EXECUTION,
//        ]],
    ];

    /**
     * @var TopMenuButtonService
     */
    private $actionButtonService;
    /**
     * @var AdminRouteService
     */
    private $adminRoute;
    /**
     * @var Marking|null
     */
    private $object;

    public function __construct(TopMenuButtonService $actionButtonService, AdminRouteService $adminRoute)
    {
        $this->actionButtonService = $actionButtonService;
        $this->adminRoute = $adminRoute;
    }

    public function build(string $role, ?int $status, string $mode)
    {
        $this->createButtonList();

        foreach ($this->accessList as $accessItem) {
            $hasRole = in_array($role, $accessItem->getRoleList());
            $hasStatus = $status === null || in_array($status, $accessItem->getStatusList());
            $hasMode = in_array($mode, $accessItem->getModeList());
            if ($hasRole && $hasStatus && $hasMode) {
                $this->actionButtonService->addButtonList($accessItem->getButtonList());
            }
        }

        if ($mode !== TopMenuButtonService::MODE_LIST) {
            $this->actionButtonService->addButton((new TopMenuButton())->setKey(TopMenuButtonService::BTN_LIST));
        }
        return $this->actionButtonService->getList();
    }

    private function createButtonList()
    {
        $this->accessList = [
            (new TopMenuAccess())
                ->setRoleList([USER::ROLE_ADMIN])
                ->setModeList([TopMenuButtonService::MODE_LIST])
                ->setButtonList([
                    (new TopMenuButton())->setKey(TopMenuButtonService::BTN_CREATE),
                ])
            ,
            (new TopMenuAccess())
                ->setRoleList([USER::ROLE_ADMIN])
                ->setStatusList([Marking::STATUS_CREATED])
                ->setModeList([TopMenuButtonService::MODE_SHOW])
                ->setButtonList([
                    (new TopMenuButton())->setKey(TopMenuButtonService::BTN_CREATE),
                    (new TopMenuButton())->setKey(TopMenuButtonService::BTN_EDIT),
                ])
            ,
            (new TopMenuAccess())
                ->setRoleList([USER::ROLE_ADMIN])
                ->setStatusList([Marking::STATUS_SEND_EXECUTION, Marking::STATUS_ACCEPT_EXECUTION])
                ->setModeList([TopMenuButtonService::MODE_SHOW])
                ->setButtonList([
                    (new TopMenuButton())->setKey(TopMenuButtonService::BTN_CREATE),
                    (new TopMenuButton())
                        ->setKey(MarkingTopMenuButtonService::BTN_REMOVE_EXECUTOR)
                        ->setTitle('Снять исполнителя')
                        ->setIcon('fa-mail-forward')
                        ->setRoute($this->adminRoute->getActionRouteName(
                            Marking::class,
                            MarkingAdminController::ROUTER_REMOVE_EXECUTOR,
                            ))
                        ->setRouteParams(['id' => $this->getObjectId()])
                    ,
                ])
            ,
            (new TopMenuAccess())
                ->setRoleList([USER::ROLE_INSPECTOR])
                ->setStatusList([Marking::STATUS_SEND_EXECUTION])
                ->setModeList([TopMenuButtonService::MODE_SHOW])
                ->setButtonList([
                    (new TopMenuButton())
                        ->setKey(MarkingTopMenuButtonService::BTN_SEND_EXECUTION)
                        ->setTitle('Принять на исполнение')
                        ->setIcon('fa-mail-forward')
                        ->setRoute($this->adminRoute->getActionRouteName(
                            Marking::class,
                            MarkingAdminController::ROUTER_CHANGE_STATUS,
                            ))
                        ->setRouteParams(['id' => $this->getObjectId(), 'status' => Marking::STATUS_ACCEPT_EXECUTION])
                    ,
                ])
            ,
            (new TopMenuAccess())
                ->setRoleList([USER::ROLE_INSPECTOR])
                ->setStatusList([Marking::STATUS_ACCEPT_EXECUTION])
                ->setModeList([TopMenuButtonService::MODE_SHOW])
                ->setButtonList([
                    (new TopMenuButton())
                        ->setKey(MarkingTopMenuButtonService::BTN_SEND_REVIEW)
                        ->setTitle('Отправить задание на проверку')
                        ->setIcon('fa-mail-forward')
                        ->setRoute($this->adminRoute->getActionRouteName(
                            Marking::class,
                            MarkingAdminController::ROUTER_CHANGE_STATUS,
                            ))
                        ->setRouteParams(['id' => $this->getObjectId(), 'status' => Marking::STATUS_SAVE])
                    ,
                ])
            ,
            (new TopMenuAccess())
                ->setRoleList([USER::ROLE_ADMIN])
                ->setStatusList([Marking::STATUS_SAVE])
                ->setModeList([TopMenuButtonService::MODE_SHOW])
                ->setButtonList([
                    (new TopMenuButton())
                        ->setKey(MarkingTopMenuButtonService::BTN_REVIEW_SUCCESS)
                        ->setTitle('Принять от Исполнителя')
                        ->setIcon('fa-mail-forward')
                        ->setRoute($this->adminRoute->getActionRouteName(
                            Marking::class,
                            MarkingAdminController::ROUTER_CHANGE_STATUS,
                            ))
                        ->setRouteParams(['id' => $this->getObjectId(), 'status' => Marking::STATUS_COMPLETE])
                    ,
                    (new TopMenuButton())
                        ->setKey(MarkingTopMenuButtonService::BTN_REVIEW_ERROR)
                        ->setScriptPath('js/topMenuButton.js')
                        ->setTitle('Отклонить/отправить на доработку')
                        ->setIcon('fa-mail-forward')
                        ->setRoute($this->adminRoute->getActionRouteName(
                            Marking::class,
                            MarkingAdminController::ROUTER_CHANGE_STATUS,
                            ))
                        ->setRouteParams(['id' => $this->getObjectId(), 'status' => Marking::STATUS_SEND_EXECUTION])
                    ,
                ])
            ,
        ];
    }

    public function setObject(?Marking $object)
    {
        $this->object = $object;
        return $this;
    }

    private function getObjectId()
    {
        return $this->object ? $this->object->getId() : null;
    }
}