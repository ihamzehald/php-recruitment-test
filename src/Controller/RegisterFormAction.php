<?php

namespace Snowdog\DevTest\Controller;
use Snowdog\DevTest\Common\CommonFunctions;

class RegisterFormAction
{
    public function execute() {
        CommonFunctions::detectLoginStatus();
        require __DIR__ . '/../view/register.phtml';
    }
}