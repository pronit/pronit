<?php

namespace Pronit\ComprasBundle\Entity\Documentos\Pedidos;

use Doctrine\ORM\Mapping as ORM;
use Pronit\CoreBundle\Entity\Documentos\ClasificadorItem;
use Symfony\Component\Serializer\Exception\Exception;

use Pronit\ComprasBundle\Entity\Documentos\ItemAbastecimientoExterno;
use Pronit\ComprasBundle\Entity\Documentos\EntradasMercancias\ItemEntradaMercancias;

use Pronit\ComprasBundle\Entity\Documentos\Pedidos\Estados\EstadoPedido;
use Pronit\ComprasBundle\Entity\Documentos\Pedidos\Estados\SinEntregar;
use Pronit\ComprasBundle\Entity\Documentos\Pedidos\Estados\Finalizado;
use Pronit\ComprasBundle\Entity\Documentos\Pedidos\Estados\EntregadoParcialmente;

/**
 *
 * @author ldelia
 * @ORM\Entity
*/
class ItemPedido extends ItemAbastecimientoExterno
{
    /**
     * @ORM\OneToOne(targetEntity="Pronit\ComprasBundle\Entity\Documentos\Pedidos\Estados\EstadoPedido", cascade={"persist", "remove"}, orphanRemoval=true)
     **/    
    protected $estado;
    
    /**
     * @ORM\OneToMany(targetEntity="Pronit\ComprasBundle\Entity\Documentos\EntradasMercancias\ItemEntradaMercancias", mappedBy="referenciaItemPedido", cascade={"ALL"})
     */
    protected $referenciasItemEntradaMercancias;    
    
    public function __construct()
    {
        parent::__construct();
        
        $this->referenciasItemEntradaMercancias = new \Doctrine\Common\Collections\ArrayCollection();
        $this->setEstado( new SinEntregar() );
    }
    
    public function __toString()
    {
        return (string) $this->getId();
    }

    public function getEstado()
    {
        return $this->estado;
    }

    protected function setEstado(EstadoPedido $estado)
    {
        $this->estado = $estado;
    }    
    
    function getReferenciasItemEntradaMercancias()
    {
        return $this->referenciasItemEntradaMercancias;
    }

    function addReferenciaItemEntradaMercancias( ItemEntradaMercancias $itemEntradaMercancias )
    {
        $this->referenciasItemEntradaMercancias[] = $itemEntradaMercancias;
    }
    
    public function registrarEntradaMercancias( ItemEntradaMercancias $itemEntradaMercancias )
    {
        if( $this->getCantidadPendienteDeEntrega() > 0 ){
            $this->setEstado( new EntregadoParcialmente() );
        }else{
            $this->setEstado( new Finalizado() );
        }        
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
