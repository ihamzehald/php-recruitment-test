<?php

namespace Snowdog\DevTest\Controller;

use Snowdog\DevTest\Model\UserManager;
use Snowdog\DevTest\Model\VarnishManager;
use Snowdog\DevTest\Model\WebsiteManager;
use Snowdog\DevTest\Common\CommonFunctions;
/**
 * @author Hamza al Darawsheh 29 Sep 2018 <ihamzehald@gmail.com>
 * Class SitemapAction
 * @package Snowdog\DevTest\Controller
 * Show upload sitemap portal
 * Ticket ref: task_6
 */
class SitemapAction
{
    /**
     * @var UserManager
     */
    private $userManager;
    /**
     * @var VarnishManager
     */
    private $varnishManager;

    /** @var \Snowdog\DevTest\Model\User $user */
    private $user;
    /**
     * @var WebsiteManager
     */
    private $websiteManager;

    public function __construct(UserManager $userManager, VarnishManager $varnishManager, WebsiteManager $websiteManager)
    {
        $this->userManager = $userManager;
        $this->varnishManager = $varnishManager;
        if(isset($_SESSION['login'])) {
            $this->user = $this->userManager->getByLogin($_SESSION['login']);
        }
        $this->websiteManager = $websiteManager;

        CommonFunctions::detectLoginStatus();
    }

    public function execute() {

        include __DIR__ . '/../view/sitemap.phtml';
    }

}