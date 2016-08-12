<?php

namespace Pronit\CoreBundle\Entity\PlanificacionProduccion;

use Doctrine\ORM\Mapping as ORM;
use Pronit\GestionBienesYServiciosBundle\Entity\Material;
use Pronit\CoreBundle\Entity\PlanificacionProduccion\ListaMateriales;

/**
 * @ORM\Entity
 * @ORM\Table(name="planificacion_hojaruta")
 */
class HojaRuta
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="string")
     */
    protected $nombre;

    /**
     * @ORM\OneToMany(targetEntity="Pronit\CoreBundle\Entity\PlanificacionProduccion\Operacion", mappedBy="hojaRuta", cascade={"PERSIST","remove"})
     */
    protected $operaciones;

    public function __construct()
    {
        $this->operaciones = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * @return mixed
     */
    public function getNombre()
    {
        return $this->nombre;
    }

    /**
     * @param mixed $nombre
     */
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;
    }

    public function getOperaciones()
    {
        return $this->operaciones;
    }

    public function addOperacion(Operacion $operacion)
    {
        $operacion->setHojaRuta($this);
        $this->operaciones[] = $operacion;
    }

    /** este método es un alias. Lo necesita symfony para los forms */
    public function addOperacione(Operacion $operacion)
    {
        $this->addOperacion($operacion);
    }
    
    public function removeOperacione(Operacion $operacion)
    {
        $this->operaciones->removeElement($operacion);
    }

    public function __toString()
    {
        return $this->getNombre();
    }
}