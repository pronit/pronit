<?php

namespace Pronit\ComprasBundle\Entity\Documentos\EntradasMercancias;

use Exception;
use Doctrine\ORM\Mapping as ORM;

use Pronit\ComprasBundle\Entity\Documentos\AbastecimientoExterno;

use Pronit\CoreBundle\Entity\Documentos\Item;
use Pronit\ComprasBundle\Entity\Documentos\EntradasMercancias\ItemEntradaMercancias;

use Pronit\ComprasBundle\Entity\Documentos\Estados\Facturacion\EstadoFacturacion;
use Pronit\ComprasBundle\Entity\Documentos\Estados\Facturacion\SinFacturar;

/**
 *
 * @author ldelia
 * @ORM\Entity
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

    protected function setEstadoFacturacion(EstadoFacturacion $estadoFacturacion)
    {
        $this->estadoFacturacion = $estadoFacturacion;
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
}

