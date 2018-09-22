<?php

namespace Snowdog\DevTest\Migration;

use Snowdog\DevTest\Core\Database;
use Snowdog\DevTest\Model\PageManager;

class Version3
{
    /**
     * @author Hamza al Darawsheh 22 Sep 2018 <ihamzehald@gmail.com>
     * DB Migration file to add last_page_visit column to pages table
     * Ticket Ref: task_3
     */
    private $database;

    /**
     * @var PageManager
     */

    private $pageManager;

    public function __construct(
        Database $database,
        PageManager $pageManager
    ) {
        $this->database = $database;
        $this->pageManager = $pageManager;
    }

    public function __invoke()
    {
        $this->updatePageTable();
    }

    /**
     * @author Hamza al Darawsheh 22 Sep 2018 <ihamzehald@gmail.com>
     * Update page table by adding last_page_visit column
     * Ticket Ref: task_3
     */
    private function updatePageTable(){
        $updateQuery = <<<SQL
ALTER TABLE `pages` ADD `last_page_visit` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP AFTER `website_id`;
SQL;
        $this->database->exec($updateQuery);
    }

}