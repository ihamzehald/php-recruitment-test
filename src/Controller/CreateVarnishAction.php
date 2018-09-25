<?php

namespace Snowdog\DevTest\Controller;

use Snowdog\DevTest\Model\UserManager;
use Snowdog\DevTest\Model\VarnishManager;

class CreateVarnishAction
{
    /**
     * @var VarnishManager
     */
    private $varnishManager;

    /**
     * @var UserManager
     */
    private $userManager;

    public function __construct(UserManager $userManager, VarnishManager $varnishManager)
    {
        $this->userManager = $userManager;
        $this->varnishManager = $varnishManager;
    }

    /**
     * @author Hamza al Darawsheh 24 Sep 2018 <ihamzehald@gmail.com>
     * Create varnish
     * Ticket Ref: task 5
     */
    public function execute()
    {
        $ip = $_POST['ip'];

        if (isset($_SESSION['login'])) {
            $user = $this->userManager->getByLogin($_SESSION['login']);
            if($user){
                if($this->varnishManager->create($user, $ip)){
                    $_SESSION['flash'] = 'Varnish ' . $ip . ' added!';
                }
            }
        }
        header('Location: /varnish');
    }
}