<?php
/**
 * Created by PhpStorm.
 * User: ruslan
 * Date: 01/07/17
 * Time: 14:34
 */

namespace Application\View\Helper\Factory;


use Application\Service\NavManager;
use Application\View\Helper\Menu;
use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;
use Zend\View\Renderer\PhpRenderer;
use Zend\View\Resolver\TemplateMapResolver;

class MenuFactory implements FactoryInterface
{


    /**
     * Create an object
     *
     * @param  ContainerInterface $container
     * @param  string $requestedName
     * @param  null|array $options
     * @return object
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $menuRenderer = new PhpRenderer();
        $resolver = new TemplateMapResolver();
        $resolver->setMap($container->get('Config')['view_manager']['template_map']);
        $menuRenderer->setResolver($resolver);
        //get navigation
        $nav = $container->get(NavManager::class);

        $navItems = $nav->getMenuItems();

        return new Menu($navItems, $menuRenderer);
    }
}