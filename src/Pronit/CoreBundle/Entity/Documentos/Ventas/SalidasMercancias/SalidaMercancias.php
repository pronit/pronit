<?php

namespace Pronit\CoreBundle\Entity\Documentos\Ventas\SalidasMercancias;

use Exception;
use Doctrine\ORM\Mapping as ORM;

use Pronit\CoreBundle\Entity\Documentos\Ventas\Ventas;

use Pronit\CoreBundle\Entity\Documentos\Item;
use Pronit\CoreBundle\Entity\Documentos\Ventas\ItemVentas;

/**
 *
 * @author ldelia
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks
 */
class SalidaMercancias extends Ventas
{
    public function __construct()
    {
        parent::__construct();        
    }    
    
    public function addItem(Item $item)
    {        
        if (! $item instanceof ItemVentas )
        {
            throw new Exception;
        }
        parent::addItem($item);
    }
    
    public function contabilizar()
    {
        parent::contabilizar();

        /* Cuando la salida de mercancias se contabiliza se "contabilizan" su items */
        
        /* @var $itemSalidaMercancias \Pronit\CoreBundle\Entity\Documentos\Ventas\SalidasMercancias\ItemSalidaMercancias  */
        foreach( $this->getItems() as $itemSalidaMercancias ){
            
            $itemSalidaMercancias->contabilizar();
        }        
    }    
}