<?php

namespace Pronit\CoreBundle\Entity\PlanificacionProduccion;

use Doctrine\ORM\Mapping as ORM;
use Pronit\GestionBienesYServiciosBundle\Entity\Material;
use Pronit\CoreBundle\Entity\PlanificacionProduccion\ListaMateriales;

/**
 * @ORM\Entity
 * @ORM\Table(name="planificacion_operacion")
 * Componente Interno/Externo (Interno tiene una relación con VersionFabricacion)
 */
class Operacion
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\ManyToOne(targetEntity="Pronit\CoreBundle\Entity\PlanificacionProduccion\HojaRuta", inversedBy="operaciones")
     * @var HojaRuta
     */
    protected $hojaRuta;

    /**
     * @ORM\Column(type="integer")
     * @var integer
     */
    protected $orden;

    /**
     * @ORM\Column(type="text")
     */
    protected $descripcion;

    /**
     * @ORM\Column(type="string")
     */
    protected $cantidad;

    /**
     * @ORM\Column(type="integer")
     */
    protected $tiempo;

    /**
     * @return HojaRuta
     */
    public function getHojaRuta()
    {
        return $this->hojaRuta;
    }

    /**
     * @param HojaRuta $hojaRuta
     * @return Operacion
     */
    public function setHojaRuta(HojaRuta $hojaRuta)
    {
        $this->hojaRuta = $hojaRuta;
        return $this;
    }

    /**
     * @return int
     */
    public function getOrden()
    {
        return $this->orden;
    }

    /**
     * @param int $orden
     * @return Operacion
     */
    public function setOrden($orden)
    {
        $this->orden = $orden;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getDescripcion()
    {
        return $this->descripcion;
    }

    /**
     * @param mixed $descripcion
     * @return Operacion
     */
    public function setDescripcion($descripcion)
    {
        $this->descripcion = $descripcion;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getCantidad()
    {
        return $this->cantidad;
    }

    /**
     * @param mixed $cantidad
     * @return Operacion
     */
    public function setCantidad($cantidad)
    {
        $this->cantidad = $cantidad;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getTiempo()
    {
        return $this->tiempo;
    }

    /**
     * @param mixed $tiempo
     * @return Operacion
     */
    public function setTiempo($tiempo)
    {
        $this->tiempo = $tiempo;
        return $this;
    }

    public function __toString()
    {
        return $this->getDescripcion();
    }
}