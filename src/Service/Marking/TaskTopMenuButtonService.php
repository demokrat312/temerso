<?php
/**
 * Created by PhpStorm.
 * User: temerso_test
 * Date: 28.05.2020
 * Time: 18:52
 */

namespace App\Service\Marking;


use App\Classes\Marking\MarkingAccessHelper;
use App\Classes\Task\TaskItemInterface;
use App\Classes\TopMenuButton\TopMenuAccess;
use App\Classes\TopMenuButton\TopMenuButton;
use App\Classes\Utils;
use App\Controller\Admin\MarkingAdminController;
use App\Entity\Inventory;
use App\Entity\Marking;
use App\Entity\User;
use App\Service\AdminRouteService;
use App\Service\TopMenuButtonService;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Csrf\TokenStorage\SessionTokenStorage;

class TaskTopMenuButtonService
{
    const BTN_SEND_EXECUTION = 'btn_send_execution'; // Отправить на исполнение
    const BTN_REMOVE_EXECUTOR = 'btn_remove_executor'; // Снять исполнителя
    const BTN_ACCEPT_EXECUTION = 'btn_accept_execution'; // Принять на исполнение
    const BTN_SEND_REVIEW = 'btn_send_review'; // Отправить задание на проверку
    const BTN_REVIEW_SUCCESS = 'btn_review_success'; // Принять от Исполнителя
    const BTN_REVIEW_ERROR = 'btn_review_error'; // Отклонить/отправить на доработку
    const BTN_EXCEL = 'btn_excel'; // Печать в excel

    const BTN_TITLE = [
        self::BTN_REVIEW_SUCCESS => 'Принять от исполнителя и синхронизировать',
        self::BTN_SEND_REVIEW => 'Отправить задание на проверку'
    ];

    /**
     * @var array |TopMenuAccess[]
     */
    private $accessList = [];

    /**
     * @var TopMenuButtonService
     */
    private $actionButtonService;
    /**
     * @var AdminRouteService
     */
    private $adminRoute;
    /**
     * @var null|TaskItemInterface|Marking|Inventory
     */
    private $object;
    /**
     * @var string
     */
    private $entityClass;
    /**
     * @var TokenStorageInterface
     */
    private $storage;

    public function __construct(TopMenuButtonService $actionButtonService, AdminRouteService $adminRoute, TokenStorageInterface $storage)
    {
        $this->actionButtonService = $actionButtonService;
        $this->adminRoute = $adminRoute;
        $this->storage = $storage;
    }

    public function build(string $role, ?int $status, string $mode)
    {
        $this->createButtonList();

        foreach ($this->accessList as $accessItem) {
            $hasRole = empty($accessItem->getRoleList()) || in_array($role, $accessItem->getRoleList());
            $hasType = empty($accessItem->getTypeList()) || Utils::in_array($this->getType(), $accessItem->getTypeList());
            $hasStatus = empty($accessItem->getStatusList()) || $status === null || in_array($status, $accessItem->getStatusList());
            $hasMode = in_array($mode, $accessItem->getModeList());
            if ($hasRole && $hasStatus && $hasMode && $hasType) {
                $this->actionButtonService->addButtonList($accessItem->getButtonList());
            }
        }

        if ($mode !== TopMenuButtonService::MODE_LIST) {
            $this->actionButtonService->addButton((new TopMenuButton())->setKey(TopMenuButtonService::BTN_LIST));
        }
        if ($mode === TopMenuButtonService::MODE_EDIT) {
            $this->actionButtonService->addButton((new TopMenuButton())->setKey(TopMenuButtonService::BTN_SHOW));
        }
        return $this->actionButtonService->getList();
    }

    private function createButtonList()
    {
        $this->accessList = [
            (new TopMenuAccess())
                ->setRoleList([User::ROLE_ADMIN])
                ->setModeList([TopMenuButtonService::MODE_LIST])
                ->setButtonList([
                    (new TopMenuButton())->setKey(TopMenuButtonService::BTN_CREATE),
                ])
            ,
            (new TopMenuAccess())
                ->setRoleList([User::ROLE_ADMIN])
                ->setStatusList([Marking::STATUS_CREATED])
                ->setModeList([TopMenuButtonService::MODE_SHOW])
                ->setButtonList([
                    (new TopMenuButton())->setKey(TopMenuButtonService::BTN_CREATE),
                    (new TopMenuButton())->setKey(TopMenuButtonService::BTN_EDIT),
                ])
            ,
            (new TopMenuAccess())
                ->setRoleList([User::ROLE_ADMIN])
                ->setStatusList([Marking::STATUS_SEND_EXECUTION, Marking::STATUS_ACCEPT_EXECUTION])
                ->setModeList([TopMenuButtonService::MODE_SHOW])
                ->setButtonList([
                    (new TopMenuButton())->setKey(TopMenuButtonService::BTN_CREATE),
                    (new TopMenuButton())
                        ->setKey(TaskTopMenuButtonService::BTN_REMOVE_EXECUTOR)
                        ->setTitle('Снять исполнителя')
                        ->setIcon('fa-mail-forward')
                        ->setRoute($this->adminRoute->getActionRouteName(
                            $this->entityClass,
                            MarkingAdminController::ROUTER_REMOVE_EXECUTOR,
                            ))
                        ->setRouteParams(['id' => $this->getObjectId()])
                    ,
                ])
            ,
            (new TopMenuAccess())
                ->setRoleList([User::ROLE_INSPECTOR, User::ROLE_STOREKEEPER])
                ->setStatusList([Marking::STATUS_SEND_EXECUTION])
                ->setModeList([TopMenuButtonService::MODE_SHOW])
                ->setButtonList([
                    (new TopMenuButton())
                        ->setKey(TaskTopMenuButtonService::BTN_SEND_EXECUTION)
                        ->setTitle('Принять на исполнение')
                        ->setIcon('fa-mail-forward')
                        ->setRoute($this->adminRoute->getActionRouteName(
                            $this->entityClass,
                            MarkingAdminController::ROUTER_CHANGE_STATUS,
                            ))
                        ->setRouteParams(['id' => $this->getObjectId(), 'status' => Marking::STATUS_ACCEPT_EXECUTION])
                    ,
                ])
            ,
            (new TopMenuAccess())
                ->setRoleList([User::ROLE_INSPECTOR, User::ROLE_STOREKEEPER])
                ->setStatusList([Marking::STATUS_ACCEPT_EXECUTION])
                ->setModeList([TopMenuButtonService::MODE_SHOW])
                ->setButtonList([
                    (new TopMenuButton())
                        ->setKey(TaskTopMenuButtonService::BTN_SEND_REVIEW)
                        ->setTitle('Отправить задание на проверку')
                        ->setIcon('fa-mail-forward')
                        ->setRoute($this->adminRoute->getActionRouteName(
                            $this->entityClass,
                            MarkingAdminController::ROUTER_CHANGE_STATUS,
                            ))
                        ->setRouteParams(['id' => $this->getObjectId(), 'status' => Marking::STATUS_SAVE])
                    ,
                ])
            ,
            (new TopMenuAccess())
                ->setRoleList([User::ROLE_ADMIN])
                ->setStatusList([Marking::STATUS_SAVE])
                ->setModeList([TopMenuButtonService::MODE_SHOW])
                ->setButtonList([
                    (new TopMenuButton())
                        ->setKey(TaskTopMenuButtonService::BTN_REVIEW_SUCCESS)
                        ->setTitle(self::BTN_TITLE[self::BTN_REVIEW_SUCCESS])
                        ->setIcon('fa-mail-forward')
                        ->setRoute($this->adminRoute->getActionRouteName(
                            $this->entityClass,
                            MarkingAdminController::ROUTER_CHANGE_STATUS,
                            ))
                        ->setRouteParams(['id' => $this->getObjectId(), 'status' => Marking::STATUS_COMPLETE])
                    ,
                    (new TopMenuButton())
                        ->setKey(TaskTopMenuButtonService::BTN_REVIEW_ERROR)
                        ->setScriptPath('js/topMenuButton.js')
                        ->setTitle('Отклонить/отправить на доработку')
                        ->setIcon('fa-mail-forward')
                        ->setRoute($this->adminRoute->getActionRouteName(
                            $this->entityClass,
                            MarkingAdminController::ROUTER_CHANGE_STATUS,
                            ))
                        ->setRouteParams(['id' => $this->getObjectId(), 'status' => Marking::STATUS_SEND_EXECUTION])
                    ,
                ])
            ,
            (new TopMenuAccess())
                ->setModeList([TopMenuButtonService::MODE_SHOW])
                ->setStatusList([Marking::STATUS_COMPLETE])
                ->setButtonList([
                    (new TopMenuButton())
                        ->setKey(TaskTopMenuButtonService::BTN_EXCEL)
                        ->setTitle('Excel')
                        ->setIcon('fa-file-excel-o')
                        ->setRoute($this->adminRoute->getActionRouteName(
                            $this->entityClass,
                            MarkingAdminController::ROUTER_EXCEL,
                            ))
                        ->setRouteParams(['id' => $this->getObjectId()])
                    ,
                ])
            ,
            (new TopMenuAccess())
                ->setRoleList([User::ROLE_ADMIN])
                ->setStatusList([Marking::STATUS_CREATED])
                ->setModeList([TopMenuButtonService::MODE_SHOW])
                ->setButtonList([
                    (new TopMenuButton())
                        ->setKey(TaskTopMenuButtonService::BTN_SEND_EXECUTION)
                        ->setTitle('Отправить на исполнение')
                        ->setIcon('fa-mail-forward')
                        ->setRoute($this->adminRoute->getActionRouteName(
                            $this->entityClass,
                            MarkingAdminController::ROUTER_CHANGE_STATUS,
                            ))
                        ->setRouteParams(['id' => $this->getObjectId(), 'status' => Marking::STATUS_SEND_EXECUTION])
                    ,
                ]),
            (new TopMenuAccess())
                ->setTypeList([MarkingAccessHelper::USER_TYPE_EXECUTOR])
                ->setStatusList([Marking::STATUS_CONTINUE])
                ->setModeList([TopMenuButtonService::MODE_SHOW])
                ->setButtonList([
                    (new TopMenuButton())
                        ->setKey(TaskTopMenuButtonService::BTN_SEND_REVIEW)
                        ->setTitle(self::BTN_TITLE[TaskTopMenuButtonService::BTN_SEND_REVIEW])
                        ->setIcon('fa-mail-forward')
                        ->setRoute($this->adminRoute->getActionRouteName(
                            $this->entityClass,
                            MarkingAdminController::ROUTER_CHANGE_STATUS,
                            ))
                        ->setRouteParams(['id' => $this->getObjectId(), 'status' => Marking::STATUS_SAVE])
                    ,
                ])
            ,
        ];
    }

    public function setObject(?TaskItemInterface $object)
    {
        $this->object = $object;
        return $this;
    }

    public function setEntityClass(string $class)
    {
        $this->entityClass = $class;

        return $this;
    }

    private function getObjectId()
    {
        return $this->object ? $this->object->getId() : null;
    }

    private function getType()
    {
        /** @var User $userCurrent */
        $userCurrent = $this->storage->getToken()->getUser();

        $typeList = [];

        if ($this->object && $this->object->getId()) {
            foreach ($this->object->getUsers() as $user) {
                if ($user->getId() === $userCurrent->getId()) {
                    $typeList[] = MarkingAccessHelper::USER_TYPE_EXECUTOR;
                    break;
                }
            }
            if ($this->object->getCreatedBy()->getId() === $userCurrent->getId()) {
                $typeList[] = MarkingAccessHelper::USER_TYPE_CREATOR;
            }
        } else if (User::ROLE_ADMIN === $userCurrent->getRoleName()) {
            $typeList[] = MarkingAccessHelper::USER_TYPE_CREATOR;
        }

        return $typeList;
    }
}