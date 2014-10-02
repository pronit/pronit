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
        "ItemPedidoValue" = "Pronit\ComprasBundle\Entity\Documentos\Pedidos\ClasificadorItemPedido",
        "ItemEntradaMercanciasValue" = "Pronit\ComprasBundle\Entity\Documentos\EntradasMercancias\ClasificadorItemEntradaMercancias",
        "ItemFacturaValue" = "Pronit\ComprasBundle\Entity\Documentos\Facturas\ClasificadorItemFactura"
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
