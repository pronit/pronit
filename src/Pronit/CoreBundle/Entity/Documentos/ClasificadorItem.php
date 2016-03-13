<?php

namespace Pronit\CoreBundle\Entity\Documentos;

use Doctrine\ORM\Mapping as ORM;

/**
 * @author ldelia
 * @ORM\Entity
 * @ORM\Table(name="core_clasificadoritem")
 * @ORM\InheritanceType("SINGLE_TABLE")
 * @ORM\DiscriminatorColumn(name="discr", type="string")
 * @ORM\DiscriminatorMap({
        "ComprasItemPedidoValue" = "Pronit\ComprasBundle\Entity\Documentos\Pedidos\ClasificadorItemPedido",
        "ComprasItemEntradaMercanciasValue" = "Pronit\ComprasBundle\Entity\Documentos\EntradasMercancias\ClasificadorItemEntradaMercancias",
        "ItemFacturaValue" = "Pronit\ComprasBundle\Entity\Documentos\Facturas\ClasificadorItemFactura",
        "ItemOrdenPagoValue" = "Pronit\ComprasBundle\Entity\Documentos\OrdenesPago\ClasificadorItemOrdenPago",
        "VentasItemPedidoValue" = "Pronit\CoreBundle\Entity\Documentos\Ventas\Pedidos\ClasificadorItemPedido",
        "VentasItemSalidaMercanciasValue" = "Pronit\CoreBundle\Entity\Documentos\Ventas\SalidasMercancias\ClasificadorItemSalidaMercancias",
        "VentasItemFacturaValue" = "Pronit\CoreBundle\Entity\Documentos\Ventas\Facturas\ClasificadorItemFactura",
        "ControllingItemImputacionSecundariaValue" = "Pronit\CoreBundle\Entity\Controlling\Documentos\ClasificadorItemImputacionSecundaria"
    })
 */
abstract class ClasificadorItem
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */    
    protected $id;

    /**
     * @ORM\Column(type="string")
     */        
    protected $nombre;
    
    /** 
     * @ORM\Column(type="string", length=5)
     */    
    protected $codigo;

    public function getId()
    {
        return $this->id;
    }

    public function getNombre()
    {
        return $this->nombre;
    }

    public function getCodigo()
    {
        return $this->codigo;
    }

    public function setNombre($nombre)
    {
        $this->nombre = $nombre;
    }

    public function setCodigo($codigo)
    {
        $this->codigo = $codigo;
    }
    
    public function __toString()
    {
        return $this->getNombre() . "(" . $this->getCodigo() . ")";
    }
}
