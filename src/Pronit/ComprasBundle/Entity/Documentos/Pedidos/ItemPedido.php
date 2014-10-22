<?php

namespace Pronit\ComprasBundle\Entity\Documentos\Pedidos;

use Doctrine\ORM\Mapping as ORM;
use Pronit\CoreBundle\Entity\Documentos\ClasificadorItem;
use Symfony\Component\Serializer\Exception\Exception;

use Pronit\ComprasBundle\Entity\Documentos\ItemAbastecimientoExterno;
use Pronit\ComprasBundle\Entity\Documentos\EntradasMercancias\ItemEntradaMercancias;

use Pronit\ComprasBundle\Entity\Documentos\Estados\Entregas\EstadoEntrega;
use Pronit\ComprasBundle\Entity\Documentos\Estados\Entregas\SinEntregar;
use Pronit\ComprasBundle\Entity\Documentos\Estados\Entregas\Finalizado;
use Pronit\ComprasBundle\Entity\Documentos\Estados\Entregas\EntregadoParcialmente;

use Pronit\ComprasBundle\Entity\Documentos\Estados\Facturacion\EstadoFacturacion;
use Pronit\ComprasBundle\Entity\Documentos\Estados\Facturacion\SinFacturar;


/**
 *
 * @author ldelia
 * @ORM\Entity
*/
class ItemPedido extends ItemAbastecimientoExterno
{
    /**
     * @ORM\OneToOne(targetEntity="Pronit\ComprasBundle\Entity\Documentos\Estados\Entregas\EstadoEntrega", cascade={"persist", "remove"}, orphanRemoval=true)
     **/    
    protected $estadoEntrega;

    /**
     * @ORM\OneToOne(targetEntity="Pronit\ComprasBundle\Entity\Documentos\Estados\Facturacion\EstadoFacturacion", cascade={"all"}, orphanRemoval=true)
     **/    
    protected $estadoFacturacion;    
    
    /**
     * @ORM\OneToMany(targetEntity="Pronit\ComprasBundle\Entity\Documentos\EntradasMercancias\ItemEntradaMercancias", mappedBy="referenciaItemPedido", cascade={"ALL"})
     */
    protected $referenciasItemEntradaMercancias;    
    
    public function __construct()
    {
        parent::__construct();
        
        $this->referenciasItemEntradaMercancias = new \Doctrine\Common\Collections\ArrayCollection();
        
        $this->setEstadoEntrega( new SinEntregar() );
        $this->setEstadoFacturacion( new SinFacturar() );
    }
    
    public function __toString()
    {
        return (string) $this->getId();
    }

    public function getEstadoEntrega()
    {
        return $this->estadoEntrega;
    }

    protected function setEstadoEntrega(EstadoEntrega $estado)
    {
        $this->estadoEntrega = $estado;
    }    

    function getEstadoFacturacion()
    {
        return $this->estadoFacturacion;
    }

    protected function setEstadoFacturacion(EstadoFacturacion $estadoFacturacion)
    {
        $this->estadoFacturacion = $estadoFacturacion;
    }    
    
    function getReferenciasItemEntradaMercancias()
    {
        return $this->referenciasItemEntradaMercancias;
    }

    function addReferenciaItemEntradaMercancias( ItemEntradaMercancias $itemEntradaMercancias )
    {
        $this->referenciasItemEntradaMercancias[] = $itemEntradaMercancias;
    }
    
    public function isEntregaFinalizada()
    {
        return $this->getEstadoEntrega() instanceof Finalizado;
    }    
    
    public function isEntregadoParcialmente()
    {
        return $this->getEstadoEntrega() instanceof EntregadoParcialmente;
    }        
    
    public function registrarEntradaMercancias( ItemEntradaMercancias $itemEntradaMercancias )
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
        
        /* @var $itemEntradaMercancias \Pronit\ComprasBundle\Entity\Documentos\EntradasMercancias\ItemEntradaMercancias */
        foreach( $this->getReferenciasItemEntradaMercancias() as $itemEntradaMercancias )
        {
            $entregado = $entregado + $itemEntradaMercancias->getCantidad();
        }
        
        return $this->getCantidad() - $entregado;
    }
        
    public function setClasificador(ClasificadorItem $clasificador) {
        if (!$clasificador instanceof ClasificadorItemPedido) {
            throw new Exception("Los items de pedido solo admiten clasificadores de items de pedido.");
        }
        parent::setClasificador($clasificador);
    }
}
