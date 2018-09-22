<?php

namespace Snowdog\DevTest\Model;

use Snowdog\DevTest\Core\Database;

class PageManager
{

    /**
     * @var Database|\PDO
     */
    private $database;

    public function __construct(Database $database)
    {
        $this->database = $database;
    }

    public function getAllByWebsite(Website $website)
    {
        $websiteId = $website->getWebsiteId();
        /** @var \PDOStatement $query */
        $query = $this->database->prepare('SELECT * FROM pages WHERE website_id = :website ORDER BY last_page_visit DESC');
        $query->bindParam(':website', $websiteId, \PDO::PARAM_INT);
        $query->execute();
        return $query->fetchAll(\PDO::FETCH_CLASS, Page::class);
    }

    public function create(Website $website, $url)
    {
        $websiteId = $website->getWebsiteId();
        /** @var \PDOStatement $statement */
        $statement = $this->database->prepare('INSERT INTO pages (url, website_id) VALUES (:url, :website)');
        $statement->bindParam(':url', $url, \PDO::PARAM_STR);
        $statement->bindParam(':website', $websiteId, \PDO::PARAM_INT);
        $statement->execute();
        return $this->database->lastInsertId();
    }

    /**
     * @author Hamza al Darawsheh 22 Sep 2018 <ihamzehald@gmail.com>
     * @param $page_id integer as the warmed page_id
     * Ticket Ref: task_3
     */
    public function updateLastPageVisit($page_id)
    {
        $current_datetime = date("Y-m-d H:i:s");

        $query = $this->database->prepare('UPDATE pages set last_page_visit = :current_datetime WHERE page_id = :page_id');
        $query->bindParam('current_datetime', $current_datetime, \PDO::PARAM_STR);
        $query->bindParam('page_id', $page_id, \PDO::PARAM_INT);

        return $query->execute();

    }

    /**
     * @author Hamza al Darawsheh 23 Sep 2018 <ihamzehald@gmail.com>
     * @return array as a list of all pages that related to the logged in user
     * Ticket Ref: Task 4
     */
    public function getAllUserPages($allUserWebsites){
        //get all logged in user websites id's
        $allUserWebsitesIds = [];

        foreach($allUserWebsites as $userWebsite){
            $allUserWebsitesIds[] = $userWebsite->getWebsiteId();
        }

        $allUserWebsitesIdsString = implode(',', $allUserWebsitesIds);

        //get all the pages that related to user websites id's
        $query = $this->database->prepare("SELECT * FROM pages WHERE website_id IN ({$allUserWebsitesIdsString}) ORDER BY last_page_visit DESC");
        $query->execute();

        return $query->fetchAll(\PDO::FETCH_CLASS, Page::class);;
    }



}