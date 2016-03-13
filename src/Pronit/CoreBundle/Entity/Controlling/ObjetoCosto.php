<?php

namespace Pronit\CoreBundle\Entity\Controlling;

use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Pronit\CoreBundle\Entity\Contabilidad\CuentasContables\Cuenta;
use Pronit\CoreBundle\Entity\Documentos\Item;

/**
 * @ORM\Entity
 * @ORM\Table(name="controlling_objetocosto")
 * @ORM\InheritanceType("SINGLE_TABLE")
 * @ORM\DiscriminatorColumn(name="discr", type="string")
 * @ORM\DiscriminatorMap({
  "CentroCostoValue" = "Pronit\CoreBundle\Entity\Controlling\CentroCosto",
  "CentroBeneficioValue" = "Pronit\CoreBundle\Entity\Controlling\CentroBeneficio",
  "OrdenValue" = "Pronit\CoreBundle\Entity\Controlling\Orden"
  })
 */
abstract class ObjetoCosto {

    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="string", length=100)
     */
    protected $nombre;

    /**
     * @ORM\ManyToOne(targetEntity="Pronit\EstructuraEmpresaBundle\Entity\SociedadFI") 
     */
    protected $sociedadFI;

    /**
     * @ORM\ManyToOne(targetEntity="Pronit\CoreBundle\Entity\Contabilidad\CuentasContables\Cuenta") 
     */
    protected $cuentaContable;

    /**
     * @ORM\Column(type="date")
     */
    protected $validezDesde;

    /**
     * @ORM\Column(type="date")
     */
    protected $validezHasta;

    /**
     *      
     * @ORM\OneToMany(targetEntity="Imputacion", mappedBy="objetoCosto", cascade={"ALL"})
     * 
     * @var ArrayCollection
     */
    private $imputaciones;

    public function __construct() {
        $this->imputaciones = new ArrayCollection();
    }

    public function getId() {
        return $this->id;
    }

    public function setNombre($valor) {
        $this->nombre = $valor;
    }

    public function getNombre() {
        return $this->nombre;
    }

    function getSociedadFI() {
        return $this->sociedadFI;
    }

    function getCuentaContable() {
        return $this->cuentaContable;
    }

    function getValidezDesde() {
        return $this->validezDesde;
    }

    function getValidezHasta() {
        return $this->validezHasta;
    }

    function setSociedadFI($sociedadFI) {
        $this->sociedadFI = $sociedadFI;
    }

    function setCuentaContable($cuentaContable) {
        $this->cuentaContable = $cuentaContable;
    }

    function setValidezDesde($validezDesde) {
        $this->validezDesde = $validezDesde;
    }

    function setValidezHasta($validezHasta) {
        $this->validezHasta = $validezHasta;
    }

    /**
     * Realiza una imputación al centro de costo actual.
     * 
     * @param DateTime $fecha
     * @param Item $itemDocumento
     * @param Cuenta $cuentaContable
     * @param float $importe
     */
    public function imputar(DateTime $fecha, Item $itemDocumento, Cuenta $cuentaContable, $importe) {
        $imputacion = new Imputacion($this, $fecha, $itemDocumento, $cuentaContable, $importe);
        $this->imputaciones->add($imputacion);
        
        return $imputacion;        
    }
    
    /**
     * 
     * @return ArrayCollection
     */
    public function getImputaciones() {
        return $this->imputaciones;
    }

    public function __toString() {
        return (string) $this->getNombre();
    }

}
