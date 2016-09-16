<?php

namespace Pronit\CoreBundle\Entity\BienesYServicios\Presentaciones;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Pronit\ParametrizacionGeneralBundle\Entity\Escala;

/**
 * @ORM\Entity
 * @ORM\Table(name="core_bienesyservicios_presentacionesventa") 
 */
class PresentacionVenta extends Presentacion {

    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\ManyToOne(targetEntity="Pronit\GestionBienesYServiciosBundle\Entity\Material", inversedBy="presentacionesVenta")
     */
    private $material;

    /**
     * @ORM\ManyToMany(targetEntity="Pronit\ParametrizacionGeneralBundle\Entity\Escala")
     */
    protected $unidades;

    /**
     * @ORM\OneToMany(targetEntity="Pronit\CoreBundle\Entity\BienesYServicios\Presentaciones\FraccionamientoCompra", mappedBy="presentacionDestino")
     */
    protected $fraccionamientosCompra;

    /**
     * @ORM\OneToOne(targetEntity="Pronit\CoreBundle\Entity\BienesYServicios\Presentaciones\FraccionamientoVenta", mappedBy="presentacionDestino")
     */
    protected $fraccionamientoVentaOrigen;

    /**
     * @ORM\OneToOne(targetEntity="Pronit\CoreBundle\Entity\BienesYServicios\Presentaciones\FraccionamientoVenta", cascade={"ALL"}, mappedBy="presentacionOrigen")
     */
    protected $fraccionamientoVentaDestino;

    public function __construct($nombre = null) {
        $this->nombre = $nombre;
        $this->unidades = new ArrayCollection();
    }

    function getNombre() {
        return $this->nombre;
    }

    function setNombre($nombre) {
        $this->nombre = $nombre;
    }

    function getMaterial() {
        return $this->material;
    }

    function setMaterial($material) {
        $this->material = $material;
    }

    /**
     * 
     * @return ArrayCollection
     */
    function getUnidades() {
        return $this->unidades;
    }

    function setUnidades($unidades) {
        $this->unidades = $unidades;
    }

    public function addUnidad(Escala $escala) {
        $this->unidades[] = $escala;
    }

    public function removeUnidad(Escala $escala) {
        $this->unidades->removeElement($escala);
    }

    function getFraccionamientoVentaOrigen() {
        return $this->fraccionamientoVentaOrigen;
    }

    function getFraccionamientoVentaDestino() {
        return $this->fraccionamientoVentaDestino;
    }

    function setFraccionamientoVentaOrigen($fraccionamientoVentaOrigen) {
        $this->fraccionamientoVentaOrigen = $fraccionamientoVentaOrigen;
    }

    function setFraccionamientoVentaDestino(FraccionamientoVenta $fraccionamientoVentaDestino) {
        $this->fraccionamientoVentaDestino = $fraccionamientoVentaDestino;
        $fraccionamientoVentaDestino->setPresentacionOrigen($this);
    }

    public function __toString() {
        return $this->nombre;
    }

}
