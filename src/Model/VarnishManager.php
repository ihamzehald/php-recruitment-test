<?php

namespace Snowdog\DevTest\Model;

use Snowdog\DevTest\Core\Database;

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

    public function __construct(Database $database)
    {
        $this->database = $database;
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
        // TODO: add logic here
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
        // TODO: add logic here
    }

    public function unlink($varnish, $website)
    {
        // TODO: add logic here
    }

}