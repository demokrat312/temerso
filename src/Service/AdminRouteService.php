<?php
/**
 * Created by PhpStorm.
 * User: temerso_test
 * Date: 28.05.2020
 * Time: 10:36
 */

namespace App\Service;


use Symfony\Component\Routing\Generator\UrlGeneratorInterface;


class AdminRouteService
{
    private $router;
    private $baseRoute = 'admin_app';

    public function __construct(UrlGeneratorInterface $router)
    {
        $this->router = $router;
    }

    public function getRoute(string $routeName)
    {
        return $this->router->generate($routeName);
    }

    public function getActionRoute(string $entityClass, string $actionName, array $params = [])
    {
        $routeName = $this->getActionRouteName($entityClass, $actionName);
        return $this->router->generate($routeName, $params);
    }

    public function getActionRouteName(string $entityClass, string $actionName)
    {
        $className = strtolower((new \ReflectionClass($entityClass))->getShortName());
        return sprintf('%s_%s_%s', $this->baseRoute, $className, $actionName);
    }

}