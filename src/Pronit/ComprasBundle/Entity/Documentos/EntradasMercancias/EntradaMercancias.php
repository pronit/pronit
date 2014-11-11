<?php

namespace Pronit\ComprasBundle\Entity\Documentos\EntradasMercancias;

use Exception;
use Doctrine\ORM\Mapping as ORM;

use Pronit\ComprasBundle\Entity\Documentos\AbastecimientoExterno;

use Pronit\CoreBundle\Entity\Documentos\Item;
use Pronit\ComprasBundle\Entity\Documentos\EntradasMercancias\ItemEntradaMercancias;

use Pronit\ComprasBundle\Entity\Documentos\Estados\Facturacion\EstadoFacturacion;
use Pronit\ComprasBundle\Entity\Documentos\Estados\Facturacion\SinFacturar;
use Pronit\ComprasBundle\Entity\Documentos\Estados\Facturacion\Finalizado as FacturacionFinalizada;
use Pronit\ComprasBundle\Entity\Documentos\Estados\Facturacion\FacturadoParcialmente;

/**
 *
 * @author ldelia
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks
 */
class EntradaMercancias extends AbastecimientoExterno
{
    /**
     * @ORM\OneToOne(targetEntity="Pronit\ComprasBundle\Entity\Documentos\Estados\Facturacion\EstadoFacturacion", cascade={"persist", "remove"}, orphanRemoval=true)
     **/    
    protected $estadoFacturacion;
    
    public function __construct()
    {
        parent::__construct();
        
        $this->setEstadoFacturacion( new SinFacturar() );
    }    
    
    public function addItem(Item $item)
    {        
        if (! $item instanceof ItemEntradaMercancias )
        {
            throw new Exception;
        }
        parent::addItem($item);
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
        
        $this->setEstadoFacturacion( null );
    }
    
    /**
     *
     * @ORM\PreFlush     
     */
    public function _preFlush()
    {
        /**
         * Al actualizar un pedido Pedido se va a intentar ejecutar este metodo. 
         * Solo aplica cuando ya está contabilizado
         */        
        if( ! $this->isContabilizado() ){
            return;
        }            
            
        $this->updateEstadoFacturacion();
    }    
    
    protected function updateEstadoFacturacion()
    {
        $itemsFacturadosParcialmente = 0;
        $itemsFinalizados = 0;
                
        $items = $this->getItems()->getIterator();
                
        $items->rewind();                                
        
        /* Itero por cada item para verificar su estado. Si ya encontré uno parcialmente facturado
         * no tiene sentido continuar: el pedido estará parcialmente facturado */
        while( ( $itemsFacturadosParcialmente == 0 ) && $items->valid() ){            
            
            /* @var $item \Pronit\ComprasBundle\Entity\Documentos\EntradasMercancias\ItemEntradaMercancias */
            $item = $items->current();   
            
            if ( $item->isFacturacionFinalizada() ){
                $itemsFinalizados++;
            }elseif( $item->isFacturadoParcialmente() ){
                $itemsFacturadosParcialmente++;
            }
            
            $items->next();            
        }
        
        if (( $itemsFacturadosParcialmente ) || (  $itemsFinalizados > 0 && $itemsFinalizados < count( $items ) ) ){
            $this->setEstadoFacturacion( new FacturadoParcialmente() );
        }elseif ( $itemsFinalizados == count( $items ) ) {
            $this->setEstadoFacturacion( new FacturacionFinalizada() );
        }else{
            $this->setEstadoFacturacion( new SinFacturar() );
        }                
    }    
    
    
    public function contabilizar()
    {
        parent::contabilizar();

        /* Cuando la entrada de mercancias se contabiliza se "contabilizan" su items */
        
        /* @var $itemEntradaMercancias \Pronit\ComprasBundle\Entity\Documentos\EntradasMercancias\ItemEntradaMercancias  */
        foreach( $this->getItems() as $itemEntradaMercancias ){
            
            $itemEntradaMercancias->contabilizar();
        }        
    }
    
    public function isFacturacionFinalizada()
    {
        return $this->getEstadoFacturacion() instanceof FacturacionFinalizada;
    }        
}