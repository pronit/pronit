<?php

namespace Pronit\CoreBundle\Entity\Documentos\Ventas\Facturas;

use Exception;
use Doctrine\ORM\Mapping as ORM;

use Pronit\CoreBundle\Entity\Documentos\Ventas\Ventas;

use Pronit\CoreBundle\Entity\Documentos\Item;
use Pronit\CoreBundle\Entity\Documentos\Ventas\Facturas\ItemFactura;
use Pronit\ParametrizacionGeneralBundle\Entity\CondicionPagos;

/**
 *
 * @author ldelia
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks
 */
class Factura extends Ventas
{
    /**
     * @ORM\ManyToOne(targetEntity="Pronit\ParametrizacionGeneralBundle\Entity\CondicionPagos")
     */    
    protected $condicionPagos;

    public function __construct()
    {
        parent::__construct();        
    }    
    
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
    
    public function getImporteTotal()
    {
        $importeTotal = 0;
        
        foreach( $this->getItems() as $item ){

            $importeTotal = $importeTotal + $item->getImporteTotal();
        }
        
        return $importeTotal;
    }        
    
    public function addItem(Item $item)
    {        
        if (! $item instanceof ItemFactura )
        {
            throw new Exception;
        }
        parent::addItem($item);
    }
    
    public function contabilizar()
    {
        parent::contabilizar();

        /* Cuando la factura se contabiliza se "contabilizan" su items */
        
        /* @var $itemFactura \Pronit\CoreBundle\Entity\Documentos\Ventas\Facturas\ItemFactura  */
        foreach( $this->getItems() as $itemFactura ){
            
            $itemFactura->contabilizar();
        }        
        
    }    
}