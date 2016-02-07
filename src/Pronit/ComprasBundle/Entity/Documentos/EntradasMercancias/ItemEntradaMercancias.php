<?php

namespace Pronit\ComprasBundle\Entity\Documentos\EntradasMercancias;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

use Pronit\ComprasBundle\Entity\Documentos\Estados\Facturacion\EstadoFacturacion;
use Pronit\ComprasBundle\Entity\Documentos\Estados\Facturacion\FacturadoParcialmente;
use Pronit\ComprasBundle\Entity\Documentos\Estados\Facturacion\Finalizado as FacturacionFinalizada;
use Pronit\ComprasBundle\Entity\Documentos\Estados\Facturacion\SinFacturar;
use Pronit\ComprasBundle\Entity\Documentos\Facturas\ItemFactura;
use Pronit\ComprasBundle\Entity\Documentos\ItemAbastecimientoExterno;
use Pronit\ComprasBundle\Entity\Documentos\Pedidos\ItemPedido;
use Pronit\CoreBundle\Entity\Documentos\ClasificadorItem;
use Pronit\CoreBundle\Entity\Controlling\ObjetoCosto;

use \Exception;


/**
 *
 * @author ldelia
 * @ORM\Entity
*/
class ItemEntradaMercancias extends ItemAbastecimientoExterno
{
    /**
     * @ORM\OneToOne(targetEntity="Pronit\ComprasBundle\Entity\Documentos\Estados\Facturacion\EstadoFacturacion", cascade={"persist", "remove"}, orphanRemoval=true)
     **/    
    protected $estadoFacturacion;

    /**
     * @ORM\ManyToOne(targetEntity="Pronit\CoreBundle\Entity\Controlling\ObjetoCosto")
     * @ORM\JoinColumn(nullable=true)
     */    
    protected $objetoCosto;    
    
    /**
     * @ORM\ManyToOne(targetEntity="Pronit\ComprasBundle\Entity\Documentos\Pedidos\ItemPedido")
     */    
    protected $itemPedidoEntregado;    
    
    /**
     * @ORM\OneToMany(targetEntity="Pronit\ComprasBundle\Entity\Documentos\Facturas\ItemFactura", mappedBy="itemEntradaMercanciasFacturado", cascade={"ALL"})
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
        if (!$clasificador instanceof ClasificadorItemEntradaMercancias) {
            throw new Exception("Los items de entrada de mercancias solo admiten clasificadores de items de entrada de mercancias.");
        }
        parent::setClasificador($clasificador);
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
    
    public function getEstadoFacturacion()
    {
        return $this->estadoFacturacion;
    }

    protected function setEstadoFacturacion(EstadoFacturacion $estadoFacturacion)
    {
        $this->estadoFacturacion = $estadoFacturacion;
    }
    
    public function isFacturacionFinalizada()
    {
        return $this->getEstadoFacturacion() instanceof FacturacionFinalizada;
    }    
    
    public function isFacturadoParcialmente()
    {
        return $this->getEstadoFacturacion() instanceof FacturadoParcialmente;
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
        $itemPedido->addReferenciaItemEntradaMercancias($this);
    }    

    
    
    function getItemFacturadores()
    {
        return $this->itemFacturadores;
    }

    function addItemFacturador(ItemFactura $itemFactura)
    {
        $this->itemFacturadores[] = $itemFactura;
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
    
    public function getCantidadFacturada()
    {
        $facturado = 0;
        
        /* @var $itemFactura \Pronit\ComprasBundle\Entity\Documentos\Facturas\ItemFactura */
        foreach( $this->getItemFacturadores() as $itemFactura )
        {
            $facturado = $facturado + $itemFactura->getCantidad();
        }
        
        return $facturado;
    }
    
    public function getCantidadPendienteDeFacturacion()
    {
        return $this->getCantidad() - $this->getCantidadFacturada();
    }
    
    public function contabilizar()
    {
        $this->getItemPedidoEntregado()->registrarEntradaMercancias($this);                
    }
}
