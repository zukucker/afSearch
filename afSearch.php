<?php

namespace afSearch;

use Shopware\Components\Plugin;
use Symfony\Component\DependencyInjection\ContainerBuilder;

/**
 * Shopware-Plugin afSearch.
 */
class afSearch extends Plugin
{

    public static function getSubscribedEvents()
    {
        return [
               'Enlight_Controller_Action_PostDispatchSecure_Frontend_Search' => 'onSearch',
            ];
    }
    /**
    * @param ContainerBuilder $container
    */
    public function build(ContainerBuilder $container)
    {
        $container->setParameter('af_search.plugin_dir', $this->getPath());
        parent::build($container);
    }

    public function onSearch(\Enlight_Event_EventArgs $args){
        $connection = $this->container->get('dbal_connection');
        $controller = $args->getSubject();
        $view = $controller->View();
        $config = $this->container->get('shopware.plugin.cached_config_reader')->getByPluginName($this->getName());
        $landingPage = $config['afSearch'];
        $getPath = "SELECT path FROM s_core_rewrite_urls WHERE org_path = 'sViewport=campaign&emotionId=".$landingPage."' ";
        $path = $connection->fetchColumn($getPath);
        $results = $view->getAssign('sSearchResults');
        $searchResults = $results['sArticlesCount'];


        if($searchResults  < 1){
            header("Location: ". $path);
            exit;
        }
    }

}
