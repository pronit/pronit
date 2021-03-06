<?php

namespace Pronit\CoreBundle\Entity\Documentos;

use Doctrine\ORM\Mapping as ORM;

use Pronit\EstructuraEmpresaBundle\Entity\SociedadFI;
use Pronit\CoreBundle\Entity\Documentos\Item;
use Pronit\CoreBundle\Entity\Documentos\ClaseDocumento;

/**
 * @ORM\Entity
 * @ORM\Table(name="core_documento")
 * @ORM\InheritanceType("SINGLE_TABLE")
 * @ORM\DiscriminatorColumn(name="discr", type="string")
 * @ORM\DiscriminatorMap({
        "ComprasPedidoValue" = "Pronit\ComprasBundle\Entity\Documentos\Pedidos\Pedido",
        "ComprasEntradaMercanciasValue" = "Pronit\ComprasBundle\Entity\Documentos\EntradasMercancias\EntradaMercancias", 
        "FacturaValue" = "Pronit\ComprasBundle\Entity\Documentos\Facturas\Factura",
        "OrdenPagoValue" = "Pronit\ComprasBundle\Entity\Documentos\OrdenesPago\OrdenPago",
        "VentasPedidoValue" = "Pronit\CoreBundle\Entity\Documentos\Ventas\Pedidos\Pedido",
        "VentasSalidaMercanciasValue" = "Pronit\CoreBundle\Entity\Documentos\Ventas\SalidasMercancias\SalidaMercancias", 
        "VentasFacturaValue" = "Pronit\CoreBundle\Entity\Documentos\Ventas\Facturas\Factura",
        "OrdenProduccionValue" = "Pronit\CoreBundle\Entity\Documentos\PlanificacionProduccion\OrdenProduccion\OrdenProduccion",
        "ControllingImputacionSecundariaValue" = "Pronit\CoreBundle\Entity\Controlling\Documentos\ImputacionSecundaria", 
    })
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
     * @ORM\ManyToOne(targetEntity="Pronit\CoreBundle\Entity\Documentos\ClaseDocumento")
     * @ORM\JoinColumn(name="clase", referencedColumnName="codigo", nullable=false)
     */
    protected $clase;
    
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
     * @ORM\Column(type="string") 
     */
    protected $textoCabecera;    

    /** 
     * @ORM\Column(type="boolean") 
     */
    protected $contabilizado;    
        
    /**
     * @ORM\OneToMany(targetEntity="Pronit\CoreBundle\Entity\Documentos\Item", mappedBy="documento", cascade={"ALL"}, orphanRemoval=true)
     */
    private $items;

    /**
     * @ORM\OneToMany(targetEntity="Pronit\CoreBundle\Entity\Documentos\ItemFinanzas", mappedBy="documento", cascade={"ALL"}, orphanRemoval=true)
     */
    private $itemsFinanzas;

    public function __construct() 
    {
        $this->setItems(new \Doctrine\Common\Collections\ArrayCollection());
        $this->setFecha(new \DateTime());
        $this->itemsFinanzas = new \Doctrine\Common\Collections\ArrayCollection();
        $this->contabilizado = false;        
    }        

    public function getId() 
    {
        return $this->id;
    }

    /**
     * 
     * @return \Pronit\EstructuraEmpresaBundle\Entity\SociedadFI
     */
    public function getSociedad() {
        return $this->sociedad;
    }

    public function setSociedad(SociedadFI $sociedad) {
        $this->sociedad = $sociedad;
    }

    public function getTextoCabecera()
    {
        return $this->textoCabecera;
    }

    public function setTextoCabecera($textoCabecera)
    {
        $this->textoCabecera = $textoCabecera;
    }    
    
    function getClase() 
    {
        return $this->clase;
    }

    function setClase(ClaseDocumento $clase) 
    {
        $this->clase = $clase;
    }    
        
    public function getNumero() {
        return $this->numero;
    }

    public function getItems() {
        return $this->items;
    }

    protected function setItems($items) {
        $this->items = $items;
    }

    public function addItem(Item $item) 
    {       
        $item->setDocumento($this);
        $this->items[] = $item;
        $this->asignarPosicionItems();
    }

    public function removeItem(Item $item) {
        $this->items->removeElement($item);
        $this->asignarPosicionItems();
    }
    
    private function asignarPosicionItems()
    {
        $posicion = 1;
        
        foreach( $this->getItems() as /* @var $item Item */  $item )
        {
            $item->setPosicion($posicion);
            $posicion++;
        }
    }

    public function getFecha() {
        return $this->fecha;
    }

    public function setNumero($numero) {
        $this->numero = $numero;
    }

    public function setFecha($fecha) {
        $this->fecha = $fecha;
    }

    public function addItemFinanzas(ItemFinanzas $item) {
        $item->setDocumento($this);
        $this->itemsFinanzas[] = $item;
    }

    public function removeItemFinanzas(ItemFinanzas $item) {
        $this->itemsFinanzas->removeElement($item);
    }

    public function getItemsFinanzas() {
        return $this->itemsFinanzas;
    }
    
    public function contabilizar()
    {
        $this->contabilizado = true;        
    }
    
    public function isContabilizado()
    {
        return $this->contabilizado;
    }    
    
    public function __toString() {
        return (string) $this->getNumero();
    }

}
