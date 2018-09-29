<?php

namespace Snowdog\DevTest\Controller;

use Snowdog\DevTest\Model\UserManager;
use Snowdog\DevTest\Model\WebsiteManager;
use Snowdog\DevTest\Model\PageManager;
use Snowdog\DevTest\Common\CommonFunctions;
use SnowDog\Tools\SitemapParser;

/**
 * @author Hamza al Darawsheh 29 Sep 2018 <ihamzehald@gmail.com>
 * Class SitemapUploadAction
 * @package Snowdog\DevTest\Controller
 * Process sitemap from UI
 * Ticket ref: task_6
 */
class SitemapUploadAction
{
    /**
     * @var UserManager
     */
    private $userManager;

    /** @var \Snowdog\DevTest\Model\User $user */
    private $user;
    /**
     * @var WebsiteManager
     */
    private $websiteManager;

    /**
     * @var PageManager
     */
    private $pageManager;

    public function __construct(UserManager $userManager, WebsiteManager $websiteManager, PageManager $pageManager)
    {
        $this->userManager = $userManager;
        if (isset($_SESSION['login'])) {
            $this->user = $this->userManager->getByLogin($_SESSION['login']);
        }
        $this->websiteManager = $websiteManager;
        $this->pageManager = $pageManager;
    }

    public function execute()
    {
        $parser = new SitemapParser();

        $uploadDir = "../uploads/";
        $fileName = $_FILES["site_map"]["name"];
        $targetUploadFIle = $uploadDir . $fileName;


        //validate file size (not > 1 MB)
        if ($_FILES["site_map"]['size'] > 1000000) {
            $_SESSION['flash'] = "File size is too big, file size should be less that or equal to 1 MB.";
            header('Location: /sitemap');
        }


        //validate file type (it should be only .xml for now)
        $fileType = strtolower(pathinfo($targetUploadFIle, PATHINFO_EXTENSION));

        if ($fileType != 'xml') {
            $_SESSION['flash'] = "Only xml files accepted.";
            header('Location: /sitemap');
        }


        move_uploaded_file($_FILES["site_map"]["tmp_name"], $targetUploadFIle);

        $parseResult = $parser->fileParser('xml', $targetUploadFIle);

        CommonFunctions::processSitemap($parseResult,$this->websiteManager, $this->pageManager, $this->user);


        header('Location: /sitemap');

    }


}