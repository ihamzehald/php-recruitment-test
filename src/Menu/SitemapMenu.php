<?php

namespace Snowdog\DevTest\Menu;

/**
 * Class SitemapMenu
 * @package Snowdog\DevTest\Menu
 * @author Hamza al Darawsheh 28 Sep 2018 <ihamzehald@gmail.com>
 * Creating sitemap menu
 * Ticket Ref: task 6
 */
class SitemapMenu extends AbstractMenu
{

    public function isActive()
    {
        return $_SERVER['REQUEST_URI'] == '/sitemap';
    }

    public function getHref()
    {
        return '/sitemap';
    }

    public function getLabel()
    {
        return 'Sitemap';
    }
}