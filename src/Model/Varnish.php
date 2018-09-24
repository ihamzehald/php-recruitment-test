<?php

namespace Snowdog\DevTest\Model;

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
    public function getIp()
    {
        return $this->ip;
    }


}
