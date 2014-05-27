<?php

namespace Pronit\CoreBundle\Entity\Documentos;

use Doctrine\ORM\Mapping as ORM;

/** 
 * @ORM\Entity
 * @ORM\Table(name="core_documentoitem")
 * @ORM\InheritanceType("SINGLE_TABLE")
 * @ORM\DiscriminatorColumn(name="discr", type="string")
 * @ORM\DiscriminatorMap({"ItemPedidoValue" = "Pronit\ComprasBundle\Entity\ItemPedido"})
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
 
    public function __construct()
    {
    }
    
    public function getId()
    {
        return $this->id;
    }

    public function getDocumento()
    {
        return $this->documento;
    }

    public function setDocumento($documento)
    {
        $this->documento = $documento;
    }    
}
