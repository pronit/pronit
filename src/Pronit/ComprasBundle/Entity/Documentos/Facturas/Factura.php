<?php

namespace Pronit\ComprasBundle\Entity\Documentos\Facturas;

use Doctrine\ORM\Mapping as ORM;
use Exception;

use Pronit\ComprasBundle\Entity\Documentos\AbastecimientoExterno;
use Pronit\CoreBundle\Entity\Documentos\Item;
use Pronit\ParametrizacionGeneralBundle\Entity\CondicionPagos;


/**
 *
 * @author gcaseres
 * @ORM\Entity
 */
class Factura extends AbastecimientoExterno 
{
    /**
     * @ORM\ManyToOne(targetEntity="Pronit\ParametrizacionGeneralBundle\Entity\CondicionPagos")
     */    
    protected $condicionPagos;

    /**
     * 
     * @return CondicionPagos
     */
    function getCondicionPagos()
    {
        return $this->condicionPagos;
    }

    function setCondicionPagos(CondicionPagos $condicionPagos)
    {
        $this->condicionPagos = $condicionPagos;
    }
    
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
    
    public function getImporteTotal()
    {
        $importeTotal = 0;
        
        foreach( $this->getItems() as $item ){

            $importeTotal = $importeTotal + $item->getImporteTotal();
        }
        
        return $importeTotal;
    }    
}
