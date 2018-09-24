<?php

namespace Snowdog\DevTest\Menu;

/**
 * Class VarnishMenu
 * @package Snowdog\DevTest\Menu
 * @author
 */
class VarnishMenu extends AbstractMenu
{

    public function isActive()
    {
        return $_SERVER['REQUEST_URI'] == '/varnish';
    }

    public function getHref()
    {
        return '/varnish';
    }

    public function getLabel()
    {
        return 'Varnish';
    }
}