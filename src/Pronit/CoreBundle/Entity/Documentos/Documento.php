<?php

namespace Pronit\CoreBundle\Entity\Documentos;

use Doctrine\ORM\Mapping as ORM;

use Pronit\EstructuraEmpresaBundle\Entity\SociedadFI;

/** 
 * @ORM\Entity
 * @ORM\Table(name="core_documento")
 * @ORM\InheritanceType("SINGLE_TABLE")
 * @ORM\DiscriminatorColumn(name="discr", type="string")
 * @ORM\DiscriminatorMap({"PedidoValue" = "Pronit\ComprasBundle\Entity\Pedido"})
 */
abstract class Documento
{
   /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;    
 
    /**
     * @ORM\ManyToOne(targetEntity="Pronit\EstructuraEmpresaBundle\Entity\SociedadFI")
     * @ORM\JoinColumn(nullable=false)
     */    
    protected $sociedad;
    
    /** 
     * @ORM\Column(type="string") 
     */
    protected $numero;
    
    /** 
     * @ORM\Column(type="date") 
     */    
    protected $fecha;    
    
    /**
     * @ORM\OneToMany(targetEntity="Pronit\CoreBundle\Entity\Documentos\Item", mappedBy="documento", cascade={"ALL"}, orphanRemoval=true)
     */
    private $items;    
    
    public function __construct(SociedadFI $sociedad, $numero, $fecha)
    {
        $this->setSociedad($sociedad);
        $this->setNumero($numero);
        $this->setFecha($fecha);        
        $this->setItems(new \Doctrine\Common\Collections\ArrayCollection() );
    }
    
    public function getId()
    {
        return $this->id;
    }

    /**
     * 
     * @return \Pronit\EstructuraEmpresaBundle\Entity\SociedadFI
     */
    public function getSociedad()
    {
        return $this->sociedad;
    }

    public function setSociedad(SociedadFI $sociedad)
    {
        $this->sociedad = $sociedad;
    }
    
    public function getNumero()
    {
        return $this->numero;
    }
    
    public function getItems()
    {
        return $this->items;
    }

    protected function setItems($items)
    {
        $this->items = $items;
    }    
    
    protected function addItem(Item $item)
    {
        $item->setDocumento($this);
        $this->items[] = $item;
    }

    public function getFecha()
    {
        return $this->fecha;
    }

    public function setNumero($numero)
    {
        $this->numero = $numero;
    }

    public function setFecha($fecha)
    {
        $this->fecha = $fecha;
    }    
}
