<?php

namespace Pronit\CoreBundle\Entity\Documentos\Ventas\Pedidos;

use Exception;
use Doctrine\ORM\Mapping as ORM;

use Pronit\CoreBundle\Entity\Documentos\Ventas\Ventas;

use Pronit\CoreBundle\Entity\Documentos\Item;
use Pronit\CoreBundle\Entity\Documentos\Ventas\Pedidos\ItemPedido;

use Pronit\CoreBundle\Entity\Documentos\Ventas\Estados\Entregas\EstadoEntrega;
use Pronit\CoreBundle\Entity\Documentos\Ventas\Estados\Entregas\SinEntregar;
use Pronit\CoreBundle\Entity\Documentos\Ventas\Estados\Entregas\Finalizado;
use Pronit\CoreBundle\Entity\Documentos\Ventas\Estados\Entregas\EntregadoParcialmente;


/**
 *
 * @author ldelia
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks
 */
class Pedido extends Ventas
{     
    /**
     * @ORM\OneToOne(targetEntity="Pronit\CoreBundle\Entity\Documentos\Ventas\Estados\Entregas\EstadoEntrega", cascade={"all"}, orphanRemoval=true)
     **/    
    protected $estadoEntrega;
    
    public function __construct()
    {
        parent::__construct();
        $this->setEstadoEntrega( new SinEntregar() );
    }    
    
    public function addItem(Item $item)
    {
        if (! $item instanceof ItemPedido )
        {
            throw new Exception;
        }
        
        parent::addItem($item);
    }    
    
    public function getEstadoEntrega()
    {
        return $this->estadoEntrega;
    }

    protected function setEstadoEntrega(EstadoEntrega $estado = null)
    {
        $this->estadoEntrega = $estado;
    }    
    
    /**
     * Los items cuando sufren algún cambio notifican al documento para que se actualice sus estados. Esto en un futuro se mejorará utilizando Observer
     */
    public function update()
    {
        /* Cuando un item le dice al Documento que se tiene que actualizar, 
         * por cuestiones de performance no se puede re-calcular en ese momento el estado.
         * En cambio, se limpia el estado, y por lo tanto, se modifica el documento.
         * Esta modificación lleva a que se ejecute el método refrescarEstados mediante HasLifecycleCallbacks */
        $this->setEstadoEntrega( null );
    }
    
    /**
     *
     * @ORM\PreFlush     
     */
    public function _prePersist()
    {
        /**
         * Al actualizar un pedido Pedido se va a intentar ejecutar este metodo. 
         * Solo aplica cuando ya está contabilizado
         */        
        if( ! $this->isContabilizado() ){
            return;
        }            
            
        $this->updateEstadoEntrega();
    }    
    
    protected function updateEstadoEntrega()
    {
        $itemsEntregadosParcialmente = 0;
        $itemsFinalizados = 0;
                
        $itemsPedido = $this->getItems()->getIterator();
                
        $itemsPedido->rewind();                                
        
        /* Itero por cada item para verificar su estado. Si ya encontré uno parcialmente entregado 
         * no tiene sentido continuar: el pedido estará parcialmente entregado  */
        while( ( $itemsEntregadosParcialmente == 0 ) && $itemsPedido->valid() ){            
            
            /* @var $itemPedido \Pronit\ComprasBundle\Entity\Documentos\Pedidos\ItemPedido */
            $itemPedido = $itemsPedido->current();   
            
            if ( $itemPedido->isEntregaFinalizada() ){
                $itemsFinalizados++;
            }elseif( $itemPedido->isEntregadoParcialmente() ){
                $itemsEntregadosParcialmente++;
            }
            
            $itemsPedido->next();            
        }
        
        if( $itemsEntregadosParcialmente ){
            $this->setEstadoEntrega( new EntregadoParcialmente() );
        }elseif ( $itemsFinalizados == count( $itemsPedido ) ) {
            $this->setEstadoEntrega( new Finalizado() );
        }else{
            $this->setEstadoEntrega( new SinEntregar() );
        }                
    }
    
    public function isEntregaFinalizada()
    {
        return $this->getEstadoEntrega() instanceof Finalizado;
    }    
    
}