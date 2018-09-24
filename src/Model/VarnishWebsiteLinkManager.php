<?php

namespace Snowdog\DevTest\Model;

use Snowdog\DevTest\Core\Database;

/**
 * @author Hamza al Darawsheh 24 Sep 2018 <ihamzehald@gmail.com>
 * VarnishWebsiteLink manager
 * Ticket Ref: task 5
 */
class VarnishWebsiteLinkManager
{

    /**
     * @var Database|\PDO
     */
    private $database;

    public function __construct(Database $database)
    {
        $this->database = $database;
    }


    public function create($varnish_id, $website_id)
    {
        $statement = $this->database->prepare(
            'INSERT INTO varnish_website_link (varnish_id, website_id)
                      VALUES (:varnish_id, :website_id)'
        );
        $statement->bindParam(':varnish_id', $varnish_id, \PDO::PARAM_STR);
        $statement->bindParam(':website_id', $website_id, \PDO::PARAM_INT);
        $statement->execute();
        return $this->database->lastInsertId();
    }

}