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


    /**
     * @author Hamza al Darawsheh 25 Sep 2018 <ihamzehald@gmail.com>
     * @param $varnish_id int as the varnish server id
     * @param $website_id int as the website id
     * @return bool
     * Ticket Ref: task 5
     */
    public function create($varnish_id, $website_id)
    {
        $statement = $this->database->prepare(
            'INSERT INTO varnish_website_link (varnish_id, website_id)
                      VALUES (:varnish_id, :website_id)'
        );
        $statement->bindParam(':varnish_id', intval($varnish_id), \PDO::PARAM_INT);
        $statement->bindParam(':website_id', intval($website_id), \PDO::PARAM_INT);
        return $statement->execute();
    }

    /**
     * @author Hamza al Darawsheh 25 Sep 2018 <ihamzehald@gmail.com>
     * @param $varnish_id int as the varnish server id
     * @param $website_id int as the website id
     * @return bool
     * Ticket Ref: task 5
     *
     * Note: we can use soft delete here by updating is_deleted field instead of removing the record
     * directly, but since there is no history records mentioned in the requirements i gonna hard delete
     * the records for now since the soft delete will add some performance issue to the process.
     *
     */
    public function delete($varnish_id, $website_id)
    {
        $query = $this->database->prepare("
                  DELETE FROM varnish_website_link
                   WHERE (varnish_id = :varnish_id and website_id = :website_id)
                   ");
        $query->bindParam(":varnish_id", $varnish_id, \PDO::PARAM_INT);
        $query->bindParam(":website_id", $website_id, \PDO::PARAM_INT);
        return $query->execute();
    }

}