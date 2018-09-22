<?php

namespace Snowdog\DevTest\Controller;

use Snowdog\DevTest\Model\User;
use Snowdog\DevTest\Model\UserManager;
use Snowdog\DevTest\Model\WebsiteManager;
use Snowdog\DevTest\Model\PageManager;

class IndexAction
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
    /**
     * @var User
     */
    private $user;

    public function __construct(UserManager $userManager, WebsiteManager $websiteManager, PageManager $pageManager)
    {
        $this->websiteManager = $websiteManager;
        $this->pageManager = $pageManager;
        $this->userManager = $userManager;
        if (isset($_SESSION['login'])) {
            $this->user = $userManager->getByLogin($_SESSION['login']);
        }
    }

    protected function getWebsites()
    {
        if($this->user) {
            return $this->websiteManager->getAllByUser($this->user);
        } 
        return [];
    }

    public function execute()
    {
        require __DIR__ . '/../view/index.phtml';
    }


    /**
     * @author Hamza al Darawsheh 23 Sep 2018 <ihamzehald@gmail.com>
     * @return array as a list of analytics related to this user
     * the analytics are User pages count, Recently visited page, Last visited page
     * Ticket Ref: Task 4
     */
    protected function getAnalytics()
    {
        $analyticsData = ['user_pages' => 0, 'recent_visited_page' =>'', 'last_visited_page'=> ''];

        if(isset($_SESSION['login'])){

            $allUserWebsites = $this->websiteManager->getAllByUser($this->user);

            $userPages = $this->pageManager->getAllUserPages($allUserWebsites);

            if(!empty($userPages)){

                $analyticsData['user_pages'] = count($userPages);

                $recentPage = $userPages[0];
                $recentVisitedPageHost = $this->websiteManager->getById($recentPage->getWebsiteId());
                $recentVisitedPage = "{$recentPage->getUrl()} in host {$recentVisitedPageHost->getHostname()}";
                $analyticsData['recent_visited_page'] = $recentVisitedPage;

                $lastPage = $userPages[(count($userPages) - 1)];
                $lastVisitedPageHost = $this->websiteManager->getById($lastPage->getWebsiteId());
                $lastVisitedPage = "{$lastPage->getUrl()} in host {$lastVisitedPageHost->getHostname()}";
                $analyticsData['last_visited_page'] = $lastVisitedPage;

            }
        }

        return $analyticsData;

    }
}