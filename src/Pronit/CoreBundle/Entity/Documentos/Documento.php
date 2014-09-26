<?php

namespace Pronit\CoreBundle\Entity\Documentos;

use Doctrine\ORM\Mapping as ORM;

use Pronit\EstructuraEmpresaBundle\Entity\SociedadFI;

/** 
 * @ORM\Entity
 * @ORM\Table(name="core_documento")
 * @ORM\InheritanceType("SINGLE_TABLE")
 * @ORM\DiscriminatorColumn(name="discr", type="string")
 * @ORM\DiscriminatorMap({"PedidoValue" = "Pronit\ComprasBundle\Entity\Documentos\Pedidos\Pedido","EntradaMercanciasValue" = "Pronit\ComprasBundle\Entity\Documentos\EntradasMercancias\EntradaMercancias", "FacturaValue" = "Pronit\ComprasBundle\Entity\Documentos\Facturas\Factura"})
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
    
    public function __construct()
    {
        $this->setItems(new \Doctrine\Common\Collections\ArrayCollection() );
        $this->setFecha( new \DateTime() );
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
    
    public function addItem(Item $item)
    {
        $item->setDocumento($this);
        $this->items[] = $item;
    }
    
    public function removeItem( Item $item )
    {
        $this->items->removeElement( $item );
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
    
    public function __toString()
    {
        return (string) $this->getNumero();
    }
}
