<?php

namespace Snowdog\DevTest\Controller;
use Snowdog\DevTest\Common\CommonFunctions;

class LoginFormAction
{

    public function execute()
    {
        CommonFunctions::detectLoginStatus();
        require __DIR__ . '/../view/login.phtml';
    }
}