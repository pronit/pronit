<?php

namespace Pronit\ComprasBundle\Entity\Documentos\Pedidos;

use Doctrine\ORM\Mapping as ORM;
use Pronit\CoreBundle\Entity\Documentos\ClasificadorItem;

use Pronit\ComprasBundle\Entity\Documentos\ItemAbastecimientoExterno;

use Pronit\ComprasBundle\Entity\Documentos\EntradasMercancias\ItemEntradaMercancias;
use Pronit\ComprasBundle\Entity\Documentos\Facturas\ItemFactura;

use Pronit\ComprasBundle\Entity\Documentos\Estados\Entregas\EstadoEntrega;
use Pronit\ComprasBundle\Entity\Documentos\Estados\Entregas\SinEntregar;
use Pronit\ComprasBundle\Entity\Documentos\Estados\Entregas\Finalizado;
use Pronit\ComprasBundle\Entity\Documentos\Estados\Entregas\EntregadoParcialmente;

use Pronit\ComprasBundle\Entity\Documentos\Estados\Facturacion\EstadoFacturacion;
use Pronit\ComprasBundle\Entity\Documentos\Estados\Facturacion\SinFacturar;
use Pronit\ComprasBundle\Entity\Documentos\Estados\Facturacion\Finalizado as FacturacionFinalizada;
use Pronit\ComprasBundle\Entity\Documentos\Estados\Facturacion\FacturadoParcialmente;

use Pronit\CoreBundle\Entity\Controlling\ObjetoCosto;
use Pronit\EstructuraEmpresaBundle\Entity\Almacen;

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
     * @ORM\ManyToOne(targetEntity="Pronit\CoreBundle\Entity\Controlling\ObjetoCosto")
     * @ORM\JoinColumn(nullable=true)
     */    
    protected $objetoCosto;    
    
    /**
     * @ORM\ManyToOne(targetEntity="Pronit\EstructuraEmpresaBundle\Entity\Almacen")
     */    
    protected $almacen;    
    
    /**
     * @ORM\OneToMany(targetEntity="Pronit\ComprasBundle\Entity\Documentos\EntradasMercancias\ItemEntradaMercancias", mappedBy="itemPedidoEntregado", cascade={"ALL"})
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

    function getAlmacen() 
    {
        return $this->almacen;
    }

    function setAlmacen($almacen) 
    {
        $this->almacen = $almacen;
    }    

    /**
     * 
     * @return ObjetoCosto
     */
    function getObjetoCosto() 
    {
        return $this->objetoCosto;
    }

    function setObjetoCosto(ObjetoCosto $objetoCosto) 
    {
        $this->objetoCosto = $objetoCosto;
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
    
    public function isFacturacionFinalizada()
    {
        return $this->getEstadoFacturacion() instanceof FacturacionFinalizada;
    }    
    
    public function isFacturadoParcialmente()
    {
        return $this->getEstadoFacturacion() instanceof FacturadoParcialmente;
    }        
    
    public function registrarFacturacion( ItemFactura $itemFactura )
    {
        if( $this->getCantidadPendienteDeFacturacion() > 0 ){
            $this->setEstadoFacturacion( new FacturadoParcialmente() );
        }else{
            $this->setEstadoFacturacion( new FacturacionFinalizada() );
        }
        $this->getDocumento()->update();
    }   
    
    public function getCantidadPendienteDeFacturacion()
    {
        // El item pedido puede estar ligado 
        // 1) a items factura ( proceso pedido - factura - entrada )
        // 2) a items entrada ( proceso pedido - entrada - factura )
        // 
        // Si está ligado a items entrada ...
        if ( $this->getReferenciasItemEntradaMercancias()->count() ){
            
            $cantidadFacturada = 0;

            /* @var $itemEntradaMercancias \Pronit\ComprasBundle\Entity\Documentos\EntradasMercancias\ItemEntradaMercancias */
            foreach( $this->getReferenciasItemEntradaMercancias() as $itemEntradaMercancias )
            {
                $cantidadFacturada = $cantidadFacturada + $itemEntradaMercancias->getCantidadFacturada();
            }

            return $this->getCantidad() - $cantidadFacturada;
        }        
    }
  
    public function setClasificador(ClasificadorItem $clasificador) 
    {
        if (!$clasificador instanceof ClasificadorItemPedido) {
            throw new \Exception("Los items de pedido solo admiten clasificadores de items de pedido.");
        }
        parent::setClasificador($clasificador);
    }
}
