<?php

namespace Snowdog\DevTest\Menu;

/**
 * Class VarnishMenu
 * @package Snowdog\DevTest\Menu
 * @author Hamza al Darawsheh 24 Sep 2018 <ihamzehald@gmail.com>
 * Creating varnish menu
 * Ticket Ref: task 5
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