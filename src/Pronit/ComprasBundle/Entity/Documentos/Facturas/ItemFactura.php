<?php

namespace Pronit\ComprasBundle\Entity\Documentos\Facturas;

use Doctrine\ORM\Mapping as ORM;

use Pronit\CoreBundle\Entity\Documentos\ClasificadorItem;
use Pronit\ComprasBundle\Entity\Documentos\ItemAbastecimientoExterno;
use Pronit\ComprasBundle\Entity\Documentos\Pedidos\ItemPedido;
use Pronit\ComprasBundle\Entity\Documentos\EntradasMercancias\ItemEntradaMercancias;

use \Exception;

/**
 *
 * @author gcaseres
 * @ORM\Entity
 */
class ItemFactura extends ItemAbastecimientoExterno {

    /**
     * @ORM\ManyToOne(targetEntity="Pronit\ComprasBundle\Entity\Documentos\EntradasMercancias\ItemEntradaMercancias")
     */    
    protected $itemEntradaMercanciasFacturado;
        
    public function setClasificador(ClasificadorItem $clasificador) 
    {
        if (!$clasificador instanceof ClasificadorItemFactura) {
            throw new Exception("Los items de facturas solo admiten clasificadores de items de facturas.");
        }
        parent::setClasificador($clasificador);
    }
    
    /**
     * 
     * @return ItemEntradaMercancias
     */
    function getItemEntradaMercanciasFacturado()
    {
        return $this->itemEntradaMercanciasFacturado;
    }

    function setItemEntradaMercanciasFacturado(ItemEntradaMercancias $item)
    {
        $this->itemEntradaMercanciasFacturado = $item;
        $item->addItemFacturador($this);
    }        
    
    
    public function contabilizar()
    {
        // todo: en un futuro va a existir tambien la relacion referenciaItemPedido ( proceso pedido - factura - entrada mercancias
        
        // en ese momento debemos registrar la facturación en uno u otro
        
        $this->getItemEntradaMercanciasFacturado()->registrarFacturacion($this);
        
        $this->getItemEntradaMercanciasFacturado()->getItemPedidoEntregado()->registrarFacturacion($this);
    }
    
    public function __toString() 
    {
        return $this->getId();
    }

}
