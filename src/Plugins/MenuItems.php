<?php

namespace JaroslawZielinski\Runner\Plugins;

use JaroslawZielinski\Runner\Menu\MenuInterface;
use Exception;

/**
 * Class MenuItems
 * @package JaroslawZielinski\Runner\Plugins
 */
class MenuItems implements MenuItemsInterface
{
    /**
     * @var FastRouterRoutingsInterface
     */
    protected $routerRoutings;

    /**
     * @var array
     */
    protected $menuItemsArray;

    /**
     * MenuItems constructor.
     * @param FastRouterRoutingsInterface $routerRoutings
     * @param array $menuItemsArray
     */
    public function __construct(FastRouterRoutingsInterface $routerRoutings, array $menuItemsArray)
    {
        $this->menuItemsArray = $menuItemsArray;
        $this->routerRoutings = $routerRoutings;
    }

    /**
     * @return array
     * @throws Exception
     */
    public function getMenuItemsArray()
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
                throw new Exception("Wrong usage of a class name in configuration yml.");
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
