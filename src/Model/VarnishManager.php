<?php

namespace Snowdog\DevTest\Model;

use Snowdog\DevTest\Core\Database;
use Snowdog\DevTest\Model\Website;
use Snowdog\DevTest\Model\VarnishWebsiteLinkManager;
/**
 * @author Hamza al Darawsheh 24 Sep 2018 <ihamzehald@gmail.com>
 * varnish table model manager
 * Ticket Ref: task 5
 */
class VarnishManager
{

    /**
     * @var Database|\PDO
     */
    private $database;

    /**
     * @var VarnishWebsiteLinkManager
     */
    private $varnishWebsiteLinkManager;

    public function __construct(Database $database, VarnishWebsiteLinkManager $varnishWebsiteLinkManager)
    {
        $this->database = $database;
        $this->varnishWebsiteLinkManager = $varnishWebsiteLinkManager;
    }

    public function getAllByUser(User $user)
    {
        $userId = $user->getUserId();
        /** @var \PDOStatement $query */
        $query = $this->database->prepare('SELECT * FROM varnish WHERE user_id = :user');
        $query->bindParam(':user', $userId, \PDO::PARAM_INT);
        $query->execute();
        return $query->fetchAll(\PDO::FETCH_CLASS, Varnish::class);
    }

    public function getWebsites(Varnish $varnish)
    {

        $varnishId = $varnish->getId();
        $query = $this->database->prepare("
                                          SELECT *
                                          FROM websites
                                          INNER JOIN varnish_website_link
                                          ON websites.website_id = varnish_website_link.website_id
                                          WHERE varnish_website_link.varnish_id = :varnish_id
                                          ");
        $query->bindParam(':varnish_id', $varnishId, \PDO::PARAM_INT);
        $query->execute();

        return $query->fetchAll(\PDO::FETCH_CLASS, Website::class);

    }

    public function getByWebsite(Website $website)
    {
        // TODO: add logic here
    }

    public function create(User $user, $ip)
    {
        $userId = $user->getUserId();
        /** @var \PDOStatement $statement */
        $statement = $this->database->prepare('INSERT INTO varnish (ip, user_id) VALUES (:ip, :user_id)');
        $statement->bindParam(':ip', $ip, \PDO::PARAM_STR);
        $statement->bindParam(':user_id', $userId, \PDO::PARAM_INT);
        $statement->execute();
        return $this->database->lastInsertId();
    }


    public function link($varnish, $website)
    {
        return $this->varnishWebsiteLinkManager->create($varnish->getId(), $website->getWebsiteId());
    }

    public function unlink($varnish, $website)
    {
        return $this->varnishWebsiteLinkManager->delete($varnish->getId(), $website->getWebsiteId());
    }

    public function getVarnishById($id){
        $id = intval($id);
        $query = $this->database->prepare("SELECT * FROM varnish WHERE id = {$id}");
        $query->execute();
        $res = $query->fetchAll(\PDO::FETCH_CLASS, Varnish::class);
        return $res[0];
    }

}