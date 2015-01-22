<?php

namespace Pronit\CoreBundle\Entity\Documentos;

use Doctrine\ORM\Mapping as ORM;
use Pronit\CoreBundle\Entity\Documentos\ClasificadorItem;

/** 
 * @ORM\Entity
 * @ORM\Table(name="core_documentoitem")
 * @ORM\InheritanceType("SINGLE_TABLE")
 * @ORM\DiscriminatorColumn(name="discr", type="string")
 * @ORM\DiscriminatorMap({"ItemPedidoValue" = "Pronit\ComprasBundle\Entity\Documentos\Pedidos\ItemPedido", "ItemEntradaMercanciasValue" = "Pronit\ComprasBundle\Entity\Documentos\EntradasMercancias\ItemEntradaMercancias", "ItemFacturaValue" = "Pronit\ComprasBundle\Entity\Documentos\Facturas\ItemFactura"})
 */
abstract class Item
{
   /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;    
    
    /** @ORM\ManyToOne(targetEntity="Documento", inversedBy="items") */
    private $documento;    
    
    /**
     * @ORM\ManyToOne(targetEntity="Pronit\CoreBundle\Entity\Documentos\ClasificadorItem")
     * @ORM\JoinColumn(nullable=false)
     */    
    protected $clasificador;
    
 
    public function __construct()
    {
    }
    
    public function getId()
    {
        return $this->id;
    }

    /**
     * 
     * @return Documento
     */
    public function getDocumento()
    {
        return $this->documento;
    }

    public function setDocumento(Documento $documento)
    {
        $this->documento = $documento;
    }
    
    public function getClasificador()
    {
        return $this->clasificador;
    }

    public function setClasificador(ClasificadorItem $clasificador)
    {
        $this->clasificador = $clasificador;
    }    
}
