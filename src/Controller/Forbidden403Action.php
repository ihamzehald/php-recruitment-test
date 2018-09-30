<?php

namespace Snowdog\DevTest\Controller;
use Snowdog\DevTest\Common\CommonFunctions;

class Forbidden403Action
{
    public function execute()
    {

        require __DIR__ . '/../view/403.phtml';
    }
}