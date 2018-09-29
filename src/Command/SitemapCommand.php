<?php

namespace Snowdog\DevTest\Command;

use Snowdog\DevTest\Model\PageManager;
use Snowdog\DevTest\Model\WebsiteManager;
use Symfony\Component\Console\Output\OutputInterface;
use Snowdog\DevTest\Model\UserManager;
use Snowdog\DevTest\Common\CommonFunctions;
use SnowDog\Tools\SitemapParser;

/**
 * @author Hamza al Darawsheh 29 Sep 2018 <ihamzehald@gmail.com>
 * Class SitemapCommand
 * @package Snowdog\DevTest\Command
 * Import XML sitemap from terminal
 * Usage: php console.php sitemap_processor user_name absolute_sitemap_path.xml
 * Example: php console.php sitemap_processor demo /home/ihamzehald/Downloads/sitemap-sample.xml
 * Ticket Ref: task_6
 */
class SitemapCommand
{
    /**
     * @var WebsiteManager
     */
    private $websiteManager;
    /**
     * @var PageManager
     */
    private $pageManager;

    /**
     * @var UserManager
     */
    private $userManager;


    public function __construct(WebsiteManager $websiteManager,
                                PageManager $pageManager,
                                UserManager $userManager)
    {
        $this->websiteManager = $websiteManager;
        $this->pageManager = $pageManager;
        $this->userManager = $userManager;

    }

    public function __invoke($user_name, $sitemap_path, OutputInterface $output)
    {
        $user = $this->userManager->getByLogin($user_name);
        $sitemapProcessingResult = null;
        if($user){

            $output->writeln("<info>Prosessing sitemap from : ({$sitemap_path})</info>");
            $parser = new SitemapParser();
            $parseResult = $parser->fileParser('xml', $sitemap_path);
            $sitemapProcessingResult = CommonFunctions::processSitemap($parseResult,$this->websiteManager, $this->pageManager, $user);
            if(!empty($sitemapProcessingResult['errors_list'])){
                $output->writeln("<error>Oops, something went worng while trying to process your sitemap.</error>");
                $output->writeln("<comment>Errors list:</comment>");
                foreach($sitemapProcessingResult['errors_list'] as $error){
                    $output->writeln("<error>{$error}</error>");
                }
            }else{
                $output->writeln("<info> {$sitemapProcessingResult['success_message']}.</info>");
            }
        }else{
            $output->writeln("<error>This uer not found.</error>");
        }


    }
}