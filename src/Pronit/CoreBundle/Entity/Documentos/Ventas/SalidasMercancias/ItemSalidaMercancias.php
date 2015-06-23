<?php

namespace Pronit\CoreBundle\Entity\Documentos\Ventas\SalidasMercancias;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;


use Pronit\CoreBundle\Entity\Documentos\ClasificadorItem;
use Pronit\CoreBundle\Entity\Documentos\Ventas\ItemVentas;
use Pronit\CoreBundle\Entity\Documentos\Ventas\Pedidos\ItemPedido;
use Pronit\CoreBundle\Entity\Documentos\Ventas\Facturas\ItemFactura;

use Pronit\CoreBundle\Entity\Documentos\Ventas\Estados\Facturacion\EstadoFacturacion;
use Pronit\CoreBundle\Entity\Documentos\Ventas\Estados\Facturacion\SinFacturar;
use Pronit\CoreBundle\Entity\Documentos\Ventas\Estados\Facturacion\FacturadoParcialmente;
use Pronit\CoreBundle\Entity\Documentos\Ventas\Estados\Facturacion\Finalizado as FacturacionFinalizada;

use \Exception;


/**
 *
 * @author ldelia
 * @ORM\Entity
*/
class ItemSalidaMercancias extends ItemVentas
{
    /**
     * @ORM\OneToOne(targetEntity="Pronit\CoreBundle\Entity\Documentos\Ventas\Estados\Facturacion\EstadoFacturacion", cascade={"persist", "remove"}, orphanRemoval=true)
     **/    
    protected $estadoFacturacion;
    
    /**
     * @ORM\ManyToOne(targetEntity="Pronit\CoreBundle\Entity\Documentos\Ventas\Pedidos\ItemPedido")
     */    
    protected $itemPedidoEntregado;    
    
    /**
     * @ORM\OneToMany(targetEntity="Pronit\CoreBundle\Entity\Documentos\Ventas\Facturas\ItemFactura", mappedBy="itemSalidaMercanciasFacturado", cascade={"ALL"})
     */
    protected $itemFacturadores;    
    

    public function __construct()
    {
        parent::__construct();
        
        $this->itemFacturadores = new ArrayCollection();
        $this->setEstadoFacturacion( new SinFacturar() );        
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
    
    function addItemFacturador(ItemFactura $itemFactura)
    {
        $this->itemFacturadores[] = $itemFactura;
    }    
    
    
    public function getEstadoFacturacion()
    {
        return $this->estadoFacturacion;
    }

    protected function setEstadoFacturacion(EstadoFacturacion $estadoFacturacion)
    {
        $this->estadoFacturacion = $estadoFacturacion;
    }    

    public function contabilizar()
    {
        $this->getItemPedidoEntregado()->registrarSalidaMercancias($this);                
    }
    
}
