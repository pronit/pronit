<?php

namespace Pronit\CoreBundle\Entity\Impuestos;

use Doctrine\ORM\Mapping as ORM;
use Pronit\CoreBundle\Entity\Impuestos\ItemIndicadorImpuestos;
use Pronit\CoreBundle\Entity\Operaciones\OperacionContable;
use Pronit\AutomatizacionBundle\Entity\Funcion;

/**
 * @ORM\Entity
 * @ORM\Table(name="core_indicadorimpuestos")
 * @author ldelia
 */
class IndicadorImpuestos {

    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="string", length=20)
     */
    private $codigo;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $nombre;

    /**
     * @ORM\OneToMany(targetEntity="Pronit\CoreBundle\Entity\Impuestos\ItemIndicadorImpuestos", mappedBy="indicadorImpuestos", cascade={"ALL"})
     */
    private $items;

    public function __construct() {
        $this->items = new \Doctrine\Common\Collections\ArrayCollection();
    }

    public function getId() {
        return $this->id;
    }

    function getCodigo() {
        return $this->codigo;
    }

    function getNombre() {
        return $this->nombre;
    }

    function setCodigo($codigo) {
        $this->codigo = $codigo;
    }

    function setNombre($nombre) {
        $this->nombre = $nombre;
    }

//    public function addItem(OperacionContable $operacionContable, Funcion $funcion, $alicuota) {
//        $this->items[] = new ItemIndicadorImpuestos($this, $operacionContable, $funcion, $alicuota);
//    }
    
    public function addItem( ItemIndicadorImpuestos $itemIndicadorImpuestos ) 
    {
        $this->items[] = $itemIndicadorImpuestos;
        $itemIndicadorImpuestos->setIndicadorImpuestos($this);
    }
    
    public function getItems() {
        return $this->items;
    }

    public function setItems( $items ) {
        $this->items = $items;
    }
    
    public function __toString() {
        return (string) $this->getCodigo() . " - " . $this->nombre;
    }

}
