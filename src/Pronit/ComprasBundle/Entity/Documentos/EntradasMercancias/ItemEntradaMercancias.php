<?php

namespace Pronit\ComprasBundle\Entity\Documentos\EntradasMercancias;

use Doctrine\ORM\Mapping as ORM;
use Pronit\ComprasBundle\Entity\Documentos\ItemAbastecimientoExterno;
use Pronit\CoreBundle\Entity\Documentos\ClasificadorItem;
use Symfony\Component\Serializer\Exception\Exception;
use Pronit\ComprasBundle\Entity\Documentos\Pedidos\ItemPedido;

use Pronit\ComprasBundle\Entity\Documentos\Estados\Facturacion\EstadoFacturacion;
use Pronit\ComprasBundle\Entity\Documentos\Estados\Facturacion\SinFacturar;

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
     * @ORM\ManyToOne(targetEntity="Pronit\ComprasBundle\Entity\Documentos\Pedidos\ItemPedido")
     */    
    protected $referenciaItemPedido;    

    public function __construct()
    {
        parent::__construct();
        $this->setEstadoFacturacion( new SinFacturar() );        
    }

    public function setClasificador(ClasificadorItem $clasificador) {
        if (!$clasificador instanceof ClasificadorItemEntradaMercancias) {
            throw new Exception("Los items de entrada de mercancias solo admiten clasificadores de items de entrada de mercancias.");
        }
        parent::setClasificador($clasificador);
    }

    function getEstadoFacturacion()
    {
        return $this->estadoFacturacion;
    }

    protected function setEstadoFacturacion(EstadoFacturacion $estadoFacturacion)
    {
        $this->estadoFacturacion = $estadoFacturacion;
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
