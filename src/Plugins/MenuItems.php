<?php

declare(strict_types=1);

namespace JaroslawZielinski\Runner\Plugins;

use JaroslawZielinski\Runner\Menu\MenuInterface;

class MenuItems implements MenuItemsInterface
{
    /**
     * @var FastRouterRoutingsInterface
     */
    private $routerRoutings;

    /**
     * @var array
     */
    private $menuItemsArray;

    public function __construct(
        FastRouterRoutingsInterface $routerRoutings,
        array $menuItemsArray
    ) {
        $this->menuItemsArray = $menuItemsArray;
        $this->routerRoutings = $routerRoutings;
    }

    /**
     * {@inheritDoc}
     * @throws \Exception
     */
    public function getMenuItemsArray(): array
    {
        //sort with asc order
        uasort($this->menuItemsArray, function ($a, $b) {
            return $a['order'] <=> $b['order'];
        });

        $sortedMenuItems = [];

        foreach ($this->menuItemsArray as $menuItem) {
            $className = $menuItem['class'];
            /** @var MenuInterface $instance */
            $instance = new $className($this->routerRoutings);

            if (!($instance instanceof MenuInterface)) {
                throw new \Exception('Wrong usage of a class name in configuration yml.');
            }

            $name = $instance->getName();
            $visible = $instance->isVisible();
            $route = $instance->getLink();

            $sortedMenuItems[$name] = [
                "visible" => $visible,
                "route" => $route
            ];
        }

        return $sortedMenuItems;
    }
}
