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

    /**
     * @param User $user
     * @return array
     */
    public function getAllByUser(User $user)
    {
        $userId = $user->getUserId();
        /** @var \PDOStatement $query */
        $query = $this->database->prepare('SELECT * FROM varnish WHERE user_id = :user');
        $query->bindParam(':user', $userId, \PDO::PARAM_INT);
        $query->execute();
        return $query->fetchAll(\PDO::FETCH_CLASS, Varnish::class);
    }

    /**
     * @author Hamza al Darawsheh 24 Sep 2018 <ihamzehald@gmail.com>
     * @param Varnish $varnish
     * @return array
     * Get all websites that linked to a varnish server
     * Ticket Ref: task 5
     */
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

    /**
     * @author Hamza al Darawsheh 25 Sep 2018 <ihamzehald@gmail.com>
     * @param \Snowdog\DevTest\Model\Website $website
     * Get the varnish server that linked to a website
     * Ticket Ref: task 5
     * Note: The UI allows multiple varnish server to be linked with the same website,
     * nothing mentioned regarding this in the requiements, in real life scenario i useally
     * ask the PM on what is the expected behavior, for now i gona get only the first linked varnish,
     * we can discuss this more at the intereview in case i passed the next step.
     */
    public function getByWebsite(Website $website)
    {
        $websiteId = $website->getWebsiteId();

        $query = $this->database->prepare("
                                          SELECT *
                                          FROM varnish
                                          INNER JOIN varnish_website_link
                                          ON varnish.id = varnish_website_link.varnish_id
                                          WHERE varnish_website_link.website_id = :website_id
                                          ");
        $query->bindParam(':website_id', $websiteId, \PDO::PARAM_INT);
        $query->execute();

        return $query->fetch();
    }

    /**
     * @author Hamza al Darawsheh 24 Sep 2018 <ihamzehald@gmail.com>
     * @param User $user
     * @param $ip
     * @return string
     * Create a varnish server
     * Ticket Ref: task 5
     */
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

    /**
     * @author Hamza al Darawsheh 24 Sep 2018 <ihamzehald@gmail.com>
     * @param $varnish
     * @param $website
     * @return bool
     * Link a varnish server to a website
     * Ticket Ref: task 5
     */
    public function link($varnish, $website)
    {
        return $this->varnishWebsiteLinkManager->create($varnish->getId(), $website->getWebsiteId());
    }

    /**
     * @author Hamza al Darawsheh 24 Sep 2018 <ihamzehald@gmail.com>
     * @param $varnish
     * @param $website
     * @return bool
     * Unlink a website from varnish server
     * Ticket Ref: task 5
     */
    public function unlink($varnish, $website)
    {
        return $this->varnishWebsiteLinkManager->delete($varnish->getId(), $website->getWebsiteId());
    }

    /**
     * @author Hamza al Darawsheh 24 Sep 2018 <ihamzehald@gmail.com>
     * @param $id
     * @return mixed
     * Get one varnish server by varnish_id
     * Ticket Ref: task 5
     */
    public function getVarnishById($id){
        $id = intval($id);
        $query = $this->database->prepare("SELECT * FROM varnish WHERE id = {$id}");
        $query->execute();
        $res = $query->fetchAll(\PDO::FETCH_CLASS, Varnish::class);
        return $res[0];
    }

}