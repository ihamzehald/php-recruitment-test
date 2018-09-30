<?php

namespace Snowdog\DevTest\Controller;

use Snowdog\DevTest\Model\UserManager;
use Snowdog\DevTest\Model\VarnishManager;
use Snowdog\DevTest\Model\WebsiteManager;
use Snowdog\DevTest\Common\CommonFunctions;

class CreateVarnishLinkAction
{
    /**
     * @var UserManager
     */
    private $userManager;
    /**
     * @var VarnishManager
     */
    private $varnishManager;
    /**
     * @var WebsiteManager
     */
    private $websiteManager;

    public function __construct(UserManager $userManager, VarnishManager $varnishManager, WebsiteManager $websiteManager)
    {
        $this->userManager = $userManager;
        $this->varnishManager = $varnishManager;
        $this->websiteManager = $websiteManager;
        CommonFunctions::detectLoginStatus();
    }

    /**
     * @author Hamza al Darawsheh 24 Sep 2018 <ihamzehald@gmail.com>
     * VarnishWebsiteLink action
     * Ticket Ref: task 5
     */
    public function execute()
    {
        $response = ["status" => false, "message" => "Oops, something went wrong."];

        $varnishWebsiteLinkStatus = $_POST['status'];

        $varnishId = $_POST['varnish_id'];
        $websiteId = $_POST['website_id'];

        $varnish = $this->varnishManager->getVarnishById($varnishId);
        $wbsite = $this->websiteManager->getById($websiteId);

        if ($varnishWebsiteLinkStatus) {
            //link this website with this varnish server

            if ($this->varnishManager->link($varnish, $wbsite)) {

                $response['status'] = true;
                $response['message'] = " {$wbsite->getHostname()} linked to {$varnish->getIP()} server.";

            }

        } else {
            //unlink this website from this varnish server

            if ($this->varnishManager->unlink($varnish, $wbsite)) {
                $response['status'] = true;
                $response['message'] = " {$wbsite->getHostname()} unlinked from {$varnish->getIP()} server.";
            }

        }

        echo json_encode($response);

    }
}