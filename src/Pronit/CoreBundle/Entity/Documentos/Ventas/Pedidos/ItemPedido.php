<?php

namespace Pronit\CoreBundle\Entity\Documentos\Ventas\Pedidos;

use Doctrine\ORM\Mapping as ORM;

use Symfony\Component\Serializer\Exception\Exception;

use Pronit\CoreBundle\Entity\Documentos\ClasificadorItem;
use Pronit\CoreBundle\Entity\Documentos\Ventas\ItemVentas;
use Pronit\CoreBundle\Entity\Documentos\Ventas\Pedidos\ClasificadorItemPedido;

use Pronit\CoreBundle\Entity\Documentos\Ventas\Estados\Entregas\EstadoEntrega;
use Pronit\CoreBundle\Entity\Documentos\Ventas\Estados\Entregas\SinEntregar;
use Pronit\CoreBundle\Entity\Documentos\Ventas\Estados\Entregas\Finalizado;
use Pronit\CoreBundle\Entity\Documentos\Ventas\Estados\Entregas\EntregadoParcialmente;

use Pronit\CoreBundle\Entity\Documentos\Ventas\SalidasMercancias\ItemSalidaMercancias;

/**
 *
 * @author ldelia
 * @ORM\Entity
*/
class ItemPedido extends ItemVentas
{
    /**
     * @ORM\OneToOne(targetEntity="Pronit\CoreBundle\Entity\Documentos\Ventas\Estados\Entregas\EstadoEntrega", cascade={"persist", "remove"}, orphanRemoval=true)
     **/    
    protected $estadoEntrega;

    /**
     * @ORM\OneToMany(targetEntity="Pronit\CoreBundle\Entity\Documentos\Ventas\SalidasMercancias\ItemSalidaMercancias", mappedBy="itemPedidoEntregado", cascade={"ALL"})
     */
    protected $referenciasItemSalidasMercancias;
    
    public function __construct()
    {
        parent::__construct(); 
        
        $this->referenciasItemSalidaMercancias = new \Doctrine\Common\Collections\ArrayCollection();
        
        $this->setEstadoEntrega( new SinEntregar() );        
    }
    
    public function __toString()
    {
        return (string) $this->getId();
    }

   public function setClasificador(ClasificadorItem $clasificador) 
    {
        if (!$clasificador instanceof ClasificadorItemPedido) {
            throw new Exception("Los items de pedido solo admiten clasificadores de items de pedido.");
        }
        parent::setClasificador($clasificador);
    }
    
    public function getEstadoEntrega()
    {
        return $this->estadoEntrega;
    }

    protected function setEstadoEntrega(EstadoEntrega $estado)
    {
        $this->estadoEntrega = $estado;
    }    

    function getReferenciasItemSalidaMercancias()
    {
        return $this->referenciasItemSalidasMercancias;
    }

    function addReferenciaItemSalidaMercancias( ItemSalidaMercancias $itemSalidaMercancias )
    {
        $this->referenciasItemSalidaMercancias[] = $itemSalidaMercancias;
    }
        
    public function isEntregaFinalizada()
    {
        return $this->getEstadoEntrega() instanceof Finalizado;
    }    
    
    public function isEntregadoParcialmente()
    {
        return $this->getEstadoEntrega() instanceof EntregadoParcialmente;
    }        
    
    public function registrarSalidaMercancias( ItemSalidaMercancias $itemSalidaMercancias )
    {
        if( $this->getCantidadPendienteDeEntrega() > 0 ){
            $this->setEstadoEntrega( new EntregadoParcialmente() );
        }else{
            $this->setEstadoEntrega( new Finalizado() );
        }
        $this->getDocumento()->update();
    }
    
    public function getCantidadPendienteDeEntrega()
    {
        $entregado = 0;
        
        /* @var $itemSalidaMercancias \Pronit\CoreBundle\Entity\Documentos\Ventas\SalidasMercancias\ItemSalidaMercancias */
        foreach( $this->getReferenciasItemSalidaMercancias() as $itemSalidaMercancias )
        {
            $entregado = $entregado + $itemSalidaMercancias->getCantidad();
        }
        
        return $this->getCantidad() - $entregado;
    }       
}
