<?php

namespace Pronit\ComprasBundle\Entity\Documentos\EntradasMercancias;

use Exception;
use Doctrine\ORM\Mapping as ORM;

use Pronit\ComprasBundle\Entity\Documentos\AbastecimientoExterno;

use Pronit\CoreBundle\Entity\Documentos\Item;
use Pronit\ComprasBundle\Entity\Documentos\EntradasMercancias\ItemEntradaMercancias;

use Pronit\ComprasBundle\Entity\Documentos\EntradasMercancias\Estados\EstadoEntradaMercancias;
use Pronit\ComprasBundle\Entity\Documentos\EntradasMercancias\Estados\SinFacturar;
/**
 *
 * @author ldelia
 * @ORM\Entity
 */
class EntradaMercancias extends AbastecimientoExterno
{
    /**
     * @ORM\OneToOne(targetEntity="Pronit\ComprasBundle\Entity\Documentos\EntradasMercancias\Estados\EstadoEntradaMercancias", cascade={"persist", "remove"}, orphanRemoval=true)
     **/    
    protected $estado;
    
    public function __construct()
    {
        parent::__construct();
        $this->setEstado( new SinFacturar() );
    }    
    
    public function addItem(Item $item)
    {        
        if (! $item instanceof ItemEntradaMercancias )
        {
            throw new Exception;
        }
        parent::addItem($item);
    }
    
    public function getEstado()
    {
        return $this->estado;
    }

    protected function setEstado(EstadoEntradaMercancias $estado)
    {
        $this->estado = $estado;
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

