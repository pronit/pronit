<?php

namespace Pronit\CoreBundle\Entity\PlanificacionProduccion;

use Doctrine\ORM\Mapping as ORM;
use Pronit\GestionBienesYServiciosBundle\Entity\Material;
use Pronit\CoreBundle\Entity\PlanificacionProduccion\ListaMateriales;
use Pronit\CoreBundle\Entity\PlanificacionProduccion\HojaRuta;
/**
 * @ORM\Entity
 * @ORM\Table(name="planificacion_versionfabricacion")
 */
class VersionFabricacion
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
     * @ORM\ManyToOne(targetEntity="Pronit\CoreBundle\Entity\PlanificacionProduccion\ListaMateriales")
     */
    protected $listaMateriales;

    /**
     * @ORM\ManyToOne(targetEntity="Pronit\CoreBundle\Entity\PlanificacionProduccion\HojaRuta")
     */
    protected $hojaRuta;

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

    /**
     * @return ListaMateriales
     */
    public function getListaMateriales()
    {
        return $this->listaMateriales;
    }

    /**
     * @param ListaMateriales $listaMateriales
     */
    public function setListaMateriales(ListaMateriales $listaMateriales)
    {
        $this->listaMateriales = $listaMateriales;
    }

    public function getMaterial()
    {
        return $this->getListaMateriales()->getMaterial();
    }

    /**
     * @return HojaRuta
     */
    public function getHojaRuta()
    {
        return $this->hojaRuta;
    }

    /**
     * @param HojaRuta $hojaRuta
     */
    public function setHojaRuta(HojaRuta $hojaRuta)
    {
        $this->hojaRuta = $hojaRuta;
    }

    public function __toString()
    {
        return $this->getNombre();
    }
}