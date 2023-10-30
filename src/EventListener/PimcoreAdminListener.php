<?php
namespace App\EventListener;

use Pimcore\Event\BundleManager\PathsEvent;

class PimcoreAdminListener
{
    public function addCSSFiles(PathsEvent $event)
    {
        
    }

    public function addJSFiles(PathsEvent $event)
    {
        $event->setPaths(
            array_merge(
                $event->getPaths(),
                [
                    '/static/js/startup.js',
                    '/static/js/menu/createNewRowController.js',
                    '/static/js/menu/settings.js',
                ]
            )
        );
    }
}