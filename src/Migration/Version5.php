<?php

namespace Snowdog\DevTest\Migration;

use Snowdog\DevTest\Core\Database;


/**
 * @author Hamza al Darawsheh 24 Sep 2018 <ihamzehald@gmail.com>
 * DB Migration file to create varnish_website_link table
 * Ticket Ref: task 5
 */
class Version5
{

    /**
     * @var Database|\PDO
     */
    private $database;


    public function __construct(
        Database $database
    ) {
        $this->database = $database;
    }

    public function __invoke()
    {
        $this->createVarnishWebsiteLinkTable();
    }

    /**
     * @author Hamza al Darawsheh 24 Sep 2018 <ihamzehald@gmail.com>
     * Create varnish_website_link table
     * This table link between varnish server and it's websites
     * Ticket Ref: task 5
     */
    private function createVarnishWebsiteLinkTable(){
$createQuery = <<<SQL
--
-- Table structure for table `varnish_website_link`
--
CREATE TABLE `varnish_website_link` (
  `id` int(11) UNSIGNED NOT NULL,
  `varnish_id` int(11) UNSIGNED NOT NULL,
  `website_id` int(11) UNSIGNED NOT NULL,
  `is_deleted` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
--
-- Indexes for table `varnish_website_link`
--
ALTER TABLE `varnish_website_link`
  ADD PRIMARY KEY (`id`),
  ADD KEY `varnish_id` (`varnish_id`),
  ADD KEY `website_id` (`website_id`);
--
-- AUTO_INCREMENT for table `varnish_website_link`
--
ALTER TABLE `varnish_website_link`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=0; 
--
-- Constraints for table `varnish_website_link`
--
ALTER TABLE `varnish_website_link`
  ADD CONSTRAINT `varnish_id_fk` FOREIGN KEY (`varnish_id`) REFERENCES `varnish` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `website_id_fk` FOREIGN KEY (`website_id`) REFERENCES `websites` (`website_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Set default value for is_deleted`
--
ALTER TABLE `varnish_website_link` CHANGE `is_deleted` `is_deleted` TINYINT(1) NOT NULL DEFAULT '0';
SQL;
        $this->database->exec($createQuery);
    }

}

