<?php

namespace Pronit\CoreBundle\Entity\Documentos;

use Pronit\CoreBundle\Entity\Contabilidad\CuentasContables\Cuenta;
use Pronit\CoreBundle\Entity\Operaciones\OperacionContable;
use Doctrine\ORM\Mapping as ORM;

/**
 * Description of ItemFinanzas
 *
 * @ORM\Entity
 * @ORM\Table(name="core_documentoitemfinanzas") 
 * @ORM\InheritanceType("SINGLE_TABLE")
 * @ORM\DiscriminatorColumn(name="discr", type="string")
 * @ORM\DiscriminatorMap({"ItemFinanzasValue" = "ItemFinanzas", "ItemFinanzasPagoValue" = "ItemFinanzasPago", "ItemFinanzasEntradaMercanciasValue" = "ItemFinanzasEntradaMercancias"})
 * @author gcaseres
 */
class ItemFinanzas {
    
   /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;
    
    /**
     * @ORM\ManyToOne(targetEntity="Documento", inversedBy="itemsFinanzas")
     * @var Documento
     */
    private $documento;
    
    /**
     * @ORM\ManyToOne(targetEntity="Item")
     * @var Documento
     */
    private $itemDocumento;
  
    /**
     * @ORM\ManyToOne(targetEntity="Pronit\CoreBundle\Entity\Operaciones\OperacionContable")
     * @var OperacionContable
     */
    private $operacion;
    
    /**
     * @ORM\ManyToOne(targetEntity="Pronit\CoreBundle\Entity\Contabilidad\CuentasContables\Cuenta")
     * @var Cuenta
     */
    private $cuenta;
    
    /**
     * @ORM\Column(type="float") 
     * @var float
     */
    private $importe;
    
    public function __construct(OperacionContable $operacion = null, Cuenta $cuenta = null, Item $itemDocumento = null, $importe = null) {
        $this->cuenta = $cuenta;
        $this->operacion = $operacion;
        $this->itemDocumento = $itemDocumento;
        $this->importe = $importe;
        if ($itemDocumento !== null) {
            $this->documento = $itemDocumento->getDocumento();
        }
    }
    
    
    public function accept(ItemFinanzasVisitor $visitor) {
        $visitor->visitItemFinanzas($this);
    }
    
    /**
     * 
     * @param Documento $value
     */
    public function setDocumento(Documento $value) {
        $this->documento = $value;
    }
    
    /**
     * 
     * @return Documento
     */
    public function getDocumento() {
        return $this->documento;
    }
    
    /**
     * 
     * @return Item
     */
    public function getItemDocumento() {
        return $this->itemDocumento;
    }
    
    /**
     * 
     * @param OperacionContable $value
     */
    public function setOperacion(OperacionContable $value) {
        $this->operacion = $value;
    }
    
    /**
     * 
     * @return OperacionContable
     */
    public function getOperacion() {
        return $this->operacion;
    }
    
    /**
     * 
     * @param Cuenta $value
     */
    public function setCuenta(Cuenta $value) {
        $this->cuenta = $value;
    }
    
    /**
     * 
     * @return Cuenta
     */
    public function getCuenta() {
        return $this->cuenta;
    }
    
    /**
     * 
     * @param float $value
     */
    public function setImporte($value) {
        $this->importe = $value;
    }
    
    /**
     * 
     * @return float
     */
    public function getImporte() {
        return $this->importe;
    }
    
}
