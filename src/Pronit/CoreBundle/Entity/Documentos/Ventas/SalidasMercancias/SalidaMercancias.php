<?php

namespace Pronit\CoreBundle\Entity\Documentos\Ventas\SalidasMercancias;

use Exception;
use Doctrine\ORM\Mapping as ORM;

use Pronit\CoreBundle\Entity\Documentos\Ventas\Ventas;

use Pronit\CoreBundle\Entity\Documentos\Item;
use Pronit\CoreBundle\Entity\Documentos\Ventas\ItemVentas;

use Pronit\CoreBundle\Entity\Documentos\Ventas\Estados\Facturacion\EstadoFacturacion;
use Pronit\CoreBundle\Entity\Documentos\Ventas\Estados\Facturacion\SinFacturar;
use Pronit\CoreBundle\Entity\Documentos\Ventas\Estados\Facturacion\FacturadoParcialmente;
use Pronit\CoreBundle\Entity\Documentos\Ventas\Estados\Facturacion\Finalizado as FacturacionFinalizada;


/**
 *
 * @author ldelia
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks
 */
class SalidaMercancias extends Ventas
{
    /**
     * @ORM\OneToOne(targetEntity="Pronit\CoreBundle\Entity\Documentos\Ventas\Estados\Facturacion\EstadoFacturacion", cascade={"persist", "remove"}, orphanRemoval=true)
     **/    
    protected $estadoFacturacion;    
    
    public function __construct()
    {
        parent::__construct();   
        
        $this->setEstadoFacturacion( new SinFacturar() );
    }    
    
    public function addItem(Item $item)
    {        
        if (! $item instanceof ItemVentas )
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
    
    public function contabilizar()
    {
        parent::contabilizar();

        /* Cuando la salida de mercancias se contabiliza se "contabilizan" su items */
        
        /* @var $itemSalidaMercancias \Pronit\CoreBundle\Entity\Documentos\Ventas\SalidasMercancias\ItemSalidaMercancias  */
        foreach( $this->getItems() as $itemSalidaMercancias ){
            
            $itemSalidaMercancias->contabilizar();
        }        
    }    
    
    public function isFacturacionFinalizada()
    {
        return $this->getEstadoFacturacion() instanceof FacturacionFinalizada;
    }            
}