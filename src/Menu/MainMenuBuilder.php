<?php

namespace Platform\Bundle\AdminBundle\Menu;

use Knp\Menu\FactoryInterface;
use Knp\Menu\ItemInterface;
use Sylius\Bundle\UiBundle\Menu\Event\MenuBuilderEvent;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

class MainMenuBuilder
{
    const EVENT_NAME = 'admin_platform.menu.main';

    /**
     * @var FactoryInterface
     */
    private $factory;

    /**
     * @var EventDispatcherInterface
     */
    private $eventDispatcher;

    /**
     * @param FactoryInterface $factory
     * @param EventDispatcherInterface $eventDispatcher
     */
    public function __construct(FactoryInterface $factory, EventDispatcherInterface $eventDispatcher)
    {
        $this->factory = $factory;
        $this->eventDispatcher = $eventDispatcher;
    }

    /**
     * @param array $options
     *
     * @return ItemInterface
     */
    public function createMenu(array $options)
    {
        $menu = $this->factory->createItem('root');

        $this->addConfigurationSubMenu($menu);

        $this->eventDispatcher->dispatch(self::EVENT_NAME, new MenuBuilderEvent($this->factory, $menu));

        return $menu;
    }

    /**
     * @param ItemInterface $menu
     */
    private function addConfigurationSubMenu(ItemInterface $menu)
    {
        $configuration = $menu
            ->addChild('configuration')
            ->setLabel('admin_platform.menu.main.configuration.header');

        $configuration
            ->addChild('locales', ['route' => 'sylius_admin_locale_index'])
            ->setLabel('admin_platform.menu.main.configuration.locales')
            ->setLabelAttribute('icon', 'translate')
        ;

        $configuration
            ->addChild('roles', ['route' => 'sylius_admin_role_index'])
            ->setLabel('admin_platform.menu.main.configuration.roles')
            ->setLabelAttribute('icon', 'low vision')
        ;

        $configuration
            ->addChild('permissions', ['route' => 'sylius_admin_permission_index'])
            ->setLabel('admin_platform.menu.main.configuration.permissions')
            ->setLabelAttribute('icon', 'shield alternate')
        ;

        $configuration
            ->addChild('admin_users', ['route' => 'admin_platform_admin_admin_user_index'])
            ->setLabel('admin_platform.menu.main.configuration.admin_users')
            ->setLabelAttribute('icon', 'users')
        ;
    }
}
