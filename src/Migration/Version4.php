<?php

namespace Snowdog\DevTest\Migration;

use Snowdog\DevTest\Core\Database;


/**
 * @author Hamza al Darawsheh 24 Sep 2018 <ihamzehald@gmail.com>
 * DB Migration file to create varnish table
 * Ticket Ref: task 5
 */
class Version4
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
        $this->createVarnishTable();
    }

    /**
     * @author Hamza al Darawsheh 24 Sep 2018 <ihamzehald@gmail.com>
     * Create varnish table
     * Ticket Ref: task 5
     */
    private function createVarnishTable(){
$createQuery = <<<SQL
CREATE TABLE `varnish` (
  `id` int(11) UNSIGNED NOT NULL,
  `ip` varchar(255) NOT NULL,
  `user_id` int(11) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

ALTER TABLE `varnish`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);
  
ALTER TABLE `varnish`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
    

ALTER TABLE `varnish`
  ADD CONSTRAINT `varnish_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;
SQL;
        $this->database->exec($createQuery);
    }

}

