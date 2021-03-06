<?php

namespace Pronit\ComprasBundle\Entity\Documentos\Pedidos;

use Exception;
use Doctrine\ORM\Mapping as ORM;

use Pronit\ComprasBundle\Entity\Documentos\AbastecimientoExterno;

use Pronit\ComprasBundle\Entity\Documentos\Estados\Entregas\EstadoEntrega;
use Pronit\ComprasBundle\Entity\Documentos\Estados\Entregas\SinEntregar;
use Pronit\ComprasBundle\Entity\Documentos\Estados\Entregas\EntregadoParcialmente;
use Pronit\ComprasBundle\Entity\Documentos\Estados\Entregas\Finalizado;

use Pronit\ComprasBundle\Entity\Documentos\Estados\Facturacion\EstadoFacturacion;
use Pronit\ComprasBundle\Entity\Documentos\Estados\Facturacion\SinFacturar;
use Pronit\ComprasBundle\Entity\Documentos\Estados\Facturacion\FacturadoParcialmente;
use Pronit\ComprasBundle\Entity\Documentos\Estados\Facturacion\Finalizado as FacturacionFinalizada;

use Pronit\CoreBundle\Entity\Documentos\Item;
use Pronit\ComprasBundle\Entity\Documentos\Pedidos\ItemPedido;

/**
 *
 * @author ldelia
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks
 */
class Pedido extends AbastecimientoExterno
{      
    /**
     * @ORM\OneToOne(targetEntity="Pronit\ComprasBundle\Entity\Documentos\Estados\Entregas\EstadoEntrega", cascade={"all"}, orphanRemoval=true)
     **/    
    protected $estadoEntrega;
    
    /**
     * @ORM\OneToOne(targetEntity="Pronit\ComprasBundle\Entity\Documentos\Estados\Facturacion\EstadoFacturacion", cascade={"all"}, orphanRemoval=true)
     **/    
    protected $estadoFacturacion;    
    
    public function __construct()
    {
        parent::__construct();
        
        $this->setEstadoEntrega( new SinEntregar() );
        $this->setEstadoFacturacion( new SinFacturar() );
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
    
    function getEstadoFacturacion()
    {
        return $this->estadoFacturacion;
    }

    protected function setEstadoFacturacion(EstadoFacturacion $estadoFacturacion = null)
    {
        $this->estadoFacturacion = $estadoFacturacion;
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
        
        $this->setEstadoFacturacion( null );
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
        
        $this->updateEstadoFactura();
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
    
    protected function updateEstadoFactura()
    {
        $itemsFacturadosParcialmente = 0;
        $itemsFinalizados = 0;
                
        $itemsPedido = $this->getItems()->getIterator();
                
        $itemsPedido->rewind();                                
        
        /* Itero por cada item para verificar su estado. Si ya encontré uno parcialmente facturado
         * no tiene sentido continuar: el pedido estará parcialmente facturado */
        while( ( $itemsFacturadosParcialmente == 0 ) && $itemsPedido->valid() ){            
            
            /* @var $itemPedido \Pronit\ComprasBundle\Entity\Documentos\Pedidos\ItemPedido */
            $itemPedido = $itemsPedido->current();   
            
            if ( $itemPedido->isFacturacionFinalizada() ){
                $itemsFinalizados++;
            }elseif( $itemPedido->isFacturadoParcialmente() ){
                $itemsFacturadosParcialmente++;
            }
            
            $itemsPedido->next();            
        }
        
        if (( $itemsFacturadosParcialmente ) || (  $itemsFinalizados > 0 && $itemsFinalizados < count( $itemsPedido ) ) ){
            $this->setEstadoFacturacion( new FacturadoParcialmente() );
        }elseif ( $itemsFinalizados == count( $itemsPedido ) ) {
            $this->setEstadoFacturacion( new FacturacionFinalizada() );
        }else{
            $this->setEstadoFacturacion( new SinFacturar() );
        }                
    }    
    
    public function isEntregaFinalizada()
    {
        return $this->getEstadoEntrega() instanceof Finalizado;
    }    
    
}