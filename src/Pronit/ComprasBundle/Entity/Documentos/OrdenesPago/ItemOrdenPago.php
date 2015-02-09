<?php

namespace Pronit\ComprasBundle\Entity\Documentos\OrdenesPago;

use Doctrine\ORM\Mapping as ORM;

use Pronit\CoreBundle\Entity\Documentos\ClasificadorItem;
use Pronit\CoreBundle\Entity\Documentos\Item;
use Pronit\CoreBundle\Entity\Contabilidad\Movimientos\GestionMovimiento\GestionMovimientoAcreedor;

use \Exception;

/**
 *
 * @author ldelia
 * @ORM\Entity
 */
class ItemOrdenPago extends Item 
{
    /**
     * @ORM\ManyToOne(targetEntity="Pronit\CoreBundle\Entity\Contabilidad\Movimientos\GestionMovimiento\GestionMovimientoAcreedor")
     */    
    protected $gestionMovimientoAcreedor;
    
    /** 
     * @ORM\Column(type="float") 
     */
    private $importe;    
    
    public function setClasificador(ClasificadorItem $clasificador)
    {
        if (!$clasificador instanceof ClasificadorItemOrdenPago) {
            throw new Exception("Los items de orden de pago solo admiten clasificadores de items de ordenes de pago.");
        }
        parent::setClasificador($clasificador);
    }  

    function getGestionMovimientoAcreedor()
    {
        return $this->gestionMovimientoAcreedor;
    }

    function setGestionMovimientoAcreedor(GestionMovimientoAcreedor $gestionMovimientoAcreedor)
    {
        $this->gestionMovimientoAcreedor = $gestionMovimientoAcreedor;
    }    
    
    function getImporte()
    {
        return $this->importe;
    }

    function setImporte($importe)
    {
        $this->importe = $importe;
    }   
    
//    public function contabilizar()
//    {
//        // todo: en un futuro va a existir tambien la relacion referenciaItemPedido ( proceso pedido - factura - entrada mercancias
//        
//        // en ese momento debemos registrar la facturación en uno u otro
//        
//        $this->getItemEntradaMercanciasFacturado()->registrarFacturacion($this);
//        
//        $this->getItemEntradaMercanciasFacturado()->getItemPedidoEntregado()->registrarFacturacion($this);
//    }
    
    public function __toString() 
    {
        return $this->getId();
    }

}
