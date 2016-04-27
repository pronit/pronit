<?php

namespace Pronit\CoreBundle\EventListener;

use Sonata\AdminBundle\Event\ConfigureMenuEvent;

class ControllingMenuBuilderListener
{
    public function addMenuItems(ConfigureMenuEvent $event)
    {
        /*
         * 
        $menu = $event->getMenu();
        
        $child = $menu
                ->getChild('Controlling')
                ->addChild('pronit_controlling_liquidacion_objetoscosto', array(
                    'route' => 'pronit_controlling_liquidacion_objetoscosto',
                    'labelAttributes' => array('icon' => 'fa fa-bar-chart'),
                ));

        $child->setLabel('Liquidación de objetos de costo');
         * 
         */
    }
}