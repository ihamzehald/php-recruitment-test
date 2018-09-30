<?php

use Snowdog\DevTest\Command\MigrateCommand;
use Snowdog\DevTest\Command\WarmCommand;
use Snowdog\DevTest\Component\CommandRepository;
use Snowdog\DevTest\Component\Menu;
use Snowdog\DevTest\Component\Migrations;
use Snowdog\DevTest\Component\RouteRepository;
use Snowdog\DevTest\Controller\CreatePageAction;
use Snowdog\DevTest\Controller\CreateWebsiteAction;
use Snowdog\DevTest\Controller\IndexAction;
use Snowdog\DevTest\Controller\LoginAction;
use Snowdog\DevTest\Controller\LoginFormAction;
use Snowdog\DevTest\Controller\LogoutAction;
use Snowdog\DevTest\Controller\RegisterAction;
use Snowdog\DevTest\Controller\RegisterFormAction;
use Snowdog\DevTest\Controller\WebsiteAction;
use Snowdog\DevTest\Menu\LoginMenu;
use Snowdog\DevTest\Menu\RegisterMenu;
use Snowdog\DevTest\Menu\WebsitesMenu;
use Snowdog\DevTest\Controller\VarnishesAction;
use Snowdog\DevTest\Controller\CreateVarnishAction;
use Snowdog\DevTest\Controller\CreateVarnishLinkAction;
use Snowdog\DevTest\Menu\VarnishMenu;
use Snowdog\DevTest\Menu\SitemapMenu;
use Snowdog\DevTest\Controller\SitemapAction;
use Snowdog\DevTest\Controller\SitemapUploadAction;
use Snowdog\DevTest\Command\SitemapCommand;
use Snowdog\DevTest\Controller\Forbidden403Action;

RouteRepository::registerRoute('GET', '/', IndexAction::class, 'execute');
RouteRepository::registerRoute('GET', '/login', LoginFormAction::class, 'execute');
RouteRepository::registerRoute('POST', '/login', LoginAction::class, 'execute');
RouteRepository::registerRoute('GET', '/logout', LogoutAction::class, 'execute');
RouteRepository::registerRoute('GET', '/register', RegisterFormAction::class, 'execute');
RouteRepository::registerRoute('POST', '/register', RegisterAction::class, 'execute');
RouteRepository::registerRoute('GET', '/website/{id:\d+}', WebsiteAction::class, 'execute');
RouteRepository::registerRoute('POST', '/website', CreateWebsiteAction::class, 'execute');
RouteRepository::registerRoute('POST', '/page', CreatePageAction::class, 'execute');

//varnish routes
RouteRepository::registerRoute('GET', '/varnish', VarnishesAction::class, 'execute');
RouteRepository::registerRoute('POST', '/varnish', CreateVarnishAction::class, 'execute');
RouteRepository::registerRoute('POST', '/varnish-link', CreateVarnishLinkAction::class, 'execute');

//Sitemap routes
RouteRepository::registerRoute('GET', '/sitemap', SitemapAction::class, 'execute');
RouteRepository::registerRoute('POST', '/sitemap-upload', SitemapUploadAction::class, 'execute');

//Error routs
RouteRepository::registerRoute('GET', '/forbidden', Forbidden403Action::class, 'execute');


CommandRepository::registerCommand('migrate_db', MigrateCommand::class);
CommandRepository::registerCommand('warm [id]', WarmCommand::class);
CommandRepository::registerCommand('sitemap_processor [user_name] [sitemap_path]', SitemapCommand::class);

Menu::register(LoginMenu::class, 200);

if($_SESSION['login']){
    Menu::register(WebsitesMenu::class, 300);
    Menu::register(VarnishMenu::class, 350);
    Menu::register(SitemapMenu::class, 400);
}else{
    Menu::register(RegisterMenu::class, 250);
}









Migrations::registerComponentMigration('Snowdog\\DevTest', 5);
