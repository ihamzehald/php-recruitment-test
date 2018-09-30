<?php

namespace Snowdog\DevTest\Common;

/**
 * @author Hamza al Darawsheh 29 Sep 2018 <ihamzehald@gmail.com>
 * Class CommonFunctions
 * @package Snowdog\DevTest\Common
 * Common functions
 * Ticket Ref: task_6
 */
class CommonFunctions
{
    public static function processSitemap($parseResult, $websiteManager, $pageManager, $user){
        $result = ['errors_list' => [], 'success_message' => ""];
        $insertedPagesCounter = 0;
       // die(print_r($parseResult));
        if (empty($parseResult['errors_list'])) {

            $website = $websiteManager->getByHost($parseResult['host'], $user->getUserId());

            $websiteId = null;

            if (!$website) {
                //insert site_map_host only if it is not already inserted to avoid duplicates
                $websiteId = $websiteManager->create($user, $parseResult['host'], $parseResult['host']);

            } else {
                $websiteId = $website['website_id'];
            }



            if ($websiteId) {

                foreach ($parseResult['urls'] as $url) {

                    $pageUrl = !empty($url['url_parts']['query']) ?
                        "{$url['url_parts']['path']}?{$url['url_parts']['query']}" :
                        $url['url_parts']['path'];
                    $pageUrl = ltrim($pageUrl, '/');
                    $pageExists = $pageManager->pageExists($websiteId, $pageUrl);

                    if (!$pageExists) {
                        //insert page only if it doesn't exist to avoid duplicates
                        //Important: pageManager->create can be optimized to only accept website_id instead of website object
                        $websiteObject = $websiteManager->getById($websiteId);

                        $pageManager->create($websiteObject, $pageUrl);
                        $insertedPagesCounter++;
                    }
                }

                $result['success_message'] = "Sit map for ( {$parseResult['host']} ) inserted  successfully, {$insertedPagesCounter} new  pages created.";
                $_SESSION['flash'] = "Sit map for ( {$parseResult['host']} ) inserted  successfully, {$insertedPagesCounter} new  pages created.";

            } else {
                $result['errors_list'][] = "Something went wrong while trying to insert the sitemap pages of ({$parseResult['host']}).";
                $_SESSION['flash'] = "Something went wrong while trying to insert the sitemap pages of ({$parseResult['host']}).";
            }


        } else {
            $result['errors_list'] = $parseResult['errors_list'];
            $_SESSION['flash'] = implode(',', $parseResult['errors_list']);
        }

        return $result;
    }


    /**
     * @author Hamza al Darawsheh 30 Sep 2018 <ihamzehald@gmail.com>
     * Detects the actions that user can access in loggedin case
     * Tciket Ref: task_7
     */
    public static function detectLoginStatus(){
        $userPages = ['login', 'register'];
        $currentUrl = $_SERVER['REQUEST_URI'];
        $urlParts = parse_url($currentUrl);
        $currentPage = trim($urlParts['path'],'/');
        //var_dump($urlParts);
        if($_SESSION['login']){
            //user loggedin
            if(in_array($currentPage, $userPages)){
                //redirect to 403 on user pages and allow other pages
                header('Location: /forbidden');
            }
        }else{
            if(!in_array($currentPage, $userPages)){
                //redirect to login on all pages and allow user pages
                header('Location: /login');
            }
        }
    }
}