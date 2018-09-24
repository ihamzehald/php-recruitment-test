<?php

namespace Snowdog\DevTest\Model;

/**
 * @author Hamza al Darawsheh 24 Sep 2018 <ihamzehald@gmail.com>
 * Varnish table model
 * Ticket Ref: task 5
 */
class Varnish
{

    public $id;
    public $ip;

    public function __construct()
    {
        $this->id = intval($this->id);
        $this->ip = $this->ip;

    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getIP()
    {
        return $this->ip;
    }


}
