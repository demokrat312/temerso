<?php
/**
 * Created by PhpStorm.
 * User: temerso_test
 * Date: 28.05.2020
 * Time: 18:26
 */

namespace App\Service;


use App\Classes\TopMenuButton\TopMenuButton;
use Sonata\AdminBundle\Templating\MutableTemplateRegistryInterface;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\Routing\RouterInterface;

class TopMenuButtonService
{
    const MODE_CREATE = 'create';
    const MODE_EDIT = 'edit';
    const MODE_HISTORY = 'history';
    const MODE_SHOW = 'show';
    const MODE_LIST = 'list';

    const BTN_CREATE = 'create';
    const BTN_EDIT = 'edit';
    const BTN_HISTORY = 'history';
    const BTN_SHOW = 'show';
    const BTN_LIST = 'list';

    private const DEFAULT_BUTTON_LIST_TEMPLATE = [
        self::BTN_CREATE => 'button_create',
        self::BTN_EDIT => 'button_edit',
        self::BTN_HISTORY => 'button_history',
        self::BTN_SHOW => 'button_show',
        self::BTN_LIST => 'button_list',
    ];

    private $list = [];

    /**
     * @var MutableTemplateRegistryInterface
     */
    private $templateRegistry;
    /**
     * @var RouterInterface
     */
    private $router;

    /**
     * TopActionButtonBuilderService constructor.
     */
    public function __construct(MutableTemplateRegistryInterface $templateRegistry, RouterInterface $router)
    {
        $this->templateRegistry = $templateRegistry;
        $this->router = $router;
    }

    public function addButton(TopMenuButton $button)
    {
        $templateName = $button->getTemplate();
        $key = $button->getKey();

        if ($templateName === null && !isset(self::DEFAULT_BUTTON_LIST_TEMPLATE[$key])) {
            throw new BadRequestHttpException('Укажите шаблон для кнопки ' . $key);
        }
        if(in_array($key, array_keys(self::DEFAULT_BUTTON_LIST_TEMPLATE))){
            $templateName = self::DEFAULT_BUTTON_LIST_TEMPLATE[$key];
            $button->setTemplate($templateName);
        }

        $route = null;
        if($button->getRoute()) {
            $route = $this->router->generate($button->getRoute(), $button->getRouteParams());
        }

        if(isset($this->list[$key])) throw new BadRequestHttpException('Такой пункт меню уже существует');

        $this->list[$key] = [
            'template' => (function (string $templateName) {
                $template = $this->templateRegistry->getTemplate($templateName);
                if ($template === null) return $templateName;
                return $template;
            })($templateName),
            'title' => $button->getTitle(),
            'icon' => $button->getIcon(),
            'key' => $button->getKey(),
            'route' => $route,
            'scriptPath' => $button->getScriptPath(),
        ];
    }

    /**
     * @param array|TopMenuButton[] $buttonList
     */
    public function addButtonList(array $buttonList)
    {
        foreach ($buttonList as $buttonKey) {
            $this->addButton($buttonKey);
        }
    }

    /**
     * @return array
     */
    public function getList(): array
    {
        return $this->list;
    }

    /**
     * @param array $list
     * @return $this
     */
    public function setList(array $list)
    {
        $this->list = $list;
        return $this;
    }

}