<?php

namespace Pronit\CoreBundle\Entity\Documentos\Ventas\Facturas;

use Exception;
use Doctrine\ORM\Mapping as ORM;

use Pronit\CoreBundle\Entity\Documentos\Ventas\Ventas;

use Pronit\CoreBundle\Entity\Documentos\Item;
use Pronit\CoreBundle\Entity\Documentos\Ventas\Facturas\ItemFactura;

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
    
    
    public function __construct()
    {
        parent::__construct();        
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

        
    }    
}