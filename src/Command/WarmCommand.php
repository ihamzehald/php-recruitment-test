<?php

namespace Snowdog\DevTest\Command;

use Snowdog\DevTest\Model\PageManager;
use Snowdog\DevTest\Model\WebsiteManager;
use Symfony\Component\Console\Output\OutputInterface;
use Snowdog\DevTest\Model\VarnishManager;

class WarmCommand
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
     * @var PageManager
     */
    private $varnishManager;

    public function __construct(WebsiteManager $websiteManager,
                                PageManager $pageManager,
                                VarnishManager $varnishManager)
    {
        $this->websiteManager = $websiteManager;
        $this->pageManager = $pageManager;
        $this->varnishManager = $varnishManager;
    }

    public function __invoke($id, OutputInterface $output)
    {
        $website = $this->websiteManager->getById($id);
        if ($website) {
            $pages = $this->pageManager->getAllByWebsite($website);

            $resolver = new \Old_Legacy_CacheWarmer_Resolver_Method();
            $actor = new \Old_Legacy_CacheWarmer_Actor();
            $actor->setActor(function ($hostname, $ip, $url) use ($output, $website) {
                $varnishServer = $this->varnishManager->getByWebsite($website);

                /**
                 * Note:
                 * here if the website assigend to a varnish server it will use
                 * the varnish IP to visit the website else it will work as it was
                 * before and use the host IP, this was not in the requirements
                 * but i find it logical and better than leaving the website without
                 * warming.
                 */
                $wram_server_text = "";
                if(isset($varnishServer['ip'])){
                    $wram_server_text = "--> Using Varnish server ip to visit the host ({$varnishServer['ip']}).";
                    $ip = $varnishServer['ip'];
                }else{
                    $wram_server_text = "--> Using the host IP to visit the host ({$ip}).";
                }

                $output->writeln($wram_server_text);
                $output->writeln('Visited <info>http://' . $hostname . '/' . $url . '</info> via IP: <comment>' . $ip . '</comment>');
            });
            $warmer = new \Old_Legacy_CacheWarmer_Warmer();
            $warmer->setResolver($resolver);

            //die(print_r($varnishServer['ip']));
            $warmer->setHostname($website->getHostname());
            $warmer->setActor($actor);

            foreach ($pages as $page) {
                $warmer->warm($page->getUrl());
                //Update last_page_visit
                $this->pageManager->updateLastPageVisit($page->getPageId());
            }
        } else {
            $output->writeln('<error>Website with ID ' . $id . ' does not exists!</error>');
        }
    }
}