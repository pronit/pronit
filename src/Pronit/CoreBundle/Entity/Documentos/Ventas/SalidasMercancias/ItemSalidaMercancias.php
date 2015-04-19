<?php

namespace Pronit\CoreBundle\Entity\Documentos\Ventas\SalidasMercancias;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;


use Pronit\CoreBundle\Entity\Documentos\ClasificadorItem;
use Pronit\CoreBundle\Entity\Documentos\Ventas\ItemVentas;
use Pronit\CoreBundle\Entity\Documentos\Ventas\Pedidos\ItemPedido;

use \Exception;


/**
 *
 * @author ldelia
 * @ORM\Entity
*/
class ItemSalidaMercancias extends ItemVentas
{
    /**
     * @ORM\ManyToOne(targetEntity="Pronit\CoreBundle\Entity\Documentos\Ventas\Pedidos\ItemPedido")
     */    
    protected $itemPedidoEntregado;    

    public function __construct()
    {
        parent::__construct();
    }

    public function setClasificador(ClasificadorItem $clasificador) 
    {
        if (!$clasificador instanceof ClasificadorItemSalidaMercancias) {
            throw new Exception("Los items de salida de mercancias solo admiten clasificadores de items de salida de mercancias.");
        }
        parent::setClasificador($clasificador);
    }

    public function __toString()
    {
        return $this->getId();
    }    

    /**
     * 
     * @return ItemPedido
     */
    function getItemPedidoEntregado()
    {
        return $this->itemPedidoEntregado;
    }

    function setItemPedidoEntregado(ItemPedido $itemPedido)
    {
        $this->itemPedidoEntregado = $itemPedido;
        $itemPedido->addReferenciaItemSalidaMercancias($this);
    }    

    public function contabilizar()
    {
        $this->getItemPedidoEntregado()->registrarSalidaMercancias($this);                
    }
    
}
