<?php

namespace Pronit\ComprasBundle\Entity\Documentos\EntradasMercancias;

use Doctrine\ORM\Mapping as ORM;

use Pronit\ComprasBundle\Entity\Documentos\ItemAbastecimientoExterno;
use Pronit\ComprasBundle\Entity\Documentos\Pedidos\ItemPedido;

use Pronit\ComprasBundle\Entity\Documentos\EntradasMercancias\Estados\EstadoEntradaMercancias;
use Pronit\ComprasBundle\Entity\Documentos\EntradasMercancias\Estados\SinFacturar;


/**
 *
 * @author ldelia
 * @ORM\Entity
*/
class ItemEntradaMercancias extends ItemAbastecimientoExterno
{
    /**
     * @ORM\OneToOne(targetEntity="Pronit\ComprasBundle\Entity\Documentos\EntradasMercancias\Estados\EstadoEntradaMercancias", cascade={"persist", "remove"}, orphanRemoval=true)
     **/    
    protected $estado;
    
    /**
     * @ORM\ManyToOne(targetEntity="Pronit\ComprasBundle\Entity\Documentos\Pedidos\ItemPedido")
     */    
    protected $referenciaItemPedido;    

    public function __construct()
    {
        parent::__construct();
        $this->setEstado( new SinFacturar() );        
    }
    
    public function getEstado()
    {
        return $this->estado;
    }

    protected function setEstado(EstadoEntradaMercancias $estado)
    {
        $this->estado = $estado;
    }    
    
    public function __toString()
    {
        return $this->getId();
    }    
    
    /**
     * 
     * @return ItemPedido
     */
    function getReferenciaItemPedido()
    {
        return $this->referenciaItemPedido;
    }

    function setReferenciaItemPedido(ItemPedido $itemPedido)
    {
        $this->referenciaItemPedido = $itemPedido;
        $itemPedido->addReferenciaItemEntradaMercancias($this);
    }    
    
    public function contabilizar()
    {
        $this->getReferenciaItemPedido()->registrarEntradaMercancias($this);                
    }
}