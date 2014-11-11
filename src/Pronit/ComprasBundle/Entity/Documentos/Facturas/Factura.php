<?php

namespace Pronit\ComprasBundle\Entity\Documentos\Facturas;

use Exception;
use Pronit\ComprasBundle\Entity\Documentos\AbastecimientoExterno;
use Pronit\CoreBundle\Entity\Documentos\Item;
use Doctrine\ORM\Mapping as ORM;

/**
 *
 * @author gcaseres
 * @ORM\Entity
 */
class Factura extends AbastecimientoExterno {

    public function addItem(Item $item) {
        if (!$item instanceof ItemFactura) {
            throw new Exception;
        }
        parent::addItem($item);
    }
    
    public function contabilizar()
    {
        parent::contabilizar();

        /* Cuando la factura se contabiliza se "contabilizan" su items */
        
        /* @var $itemFactura \Pronit\ComprasBundle\Entity\Documentos\Facturas\ItemFactura  */
        foreach( $this->getItems() as $itemFactura ){
            
            $itemFactura->contabilizar();
        }        
    }   
}
