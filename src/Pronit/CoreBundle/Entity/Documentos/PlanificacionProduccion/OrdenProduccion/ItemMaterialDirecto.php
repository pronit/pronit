<?php

namespace Pronit\CoreBundle\Entity\Documentos\PlanificacionProduccion\OrdenProduccion;


use Doctrine\ORM\Mapping as ORM;

use Pronit\CoreBundle\Entity\Documentos\Item;
use Pronit\ParametrizacionGeneralBundle\Entity\Escala;

/**
 * @package Pronit\CoreBundle\Entity\Documentos\PlanificacionProduccion
 * @ORM\Entity
 */
class ItemMaterialDirecto extends ItemOrdenProduccion
{
    /**
     * @ORM\Column(type="float")
     */
    protected $costoUnitarioML;

    /**
     * @ORM\Column(type="float")
     */
    protected $eficiencia;

    /**
     * @ORM\Column(type="float")
     */
    protected $cantidad;

    /**
     * @ORM\ManyToOne(targetEntity="Pronit\ParametrizacionGeneralBundle\Entity\Escala")
     */
    protected $escala;

    /**
     * @return mixed
     */
    public function getCostoUnitarioML()
    {
        return $this->costoUnitarioML;
    }

    /**
     * @param mixed $costoUnitarioML
     */
    public function setCostoUnitarioML($costoUnitarioML)
    {
        $this->costoUnitarioML = $costoUnitarioML;
    }

    /**
     * @return mixed
     */
    public function getEficiencia()
    {
        return $this->eficiencia;
    }

    /**
     * @param mixed $eficiencia
     */
    public function setEficiencia($eficiencia)
    {
        $this->eficiencia = $eficiencia;
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
     */
    public function setCantidad($cantidad)
    {
        $this->cantidad = $cantidad;
    }

    /**
     * @return Escala
     */
    public function getEscala()
    {
        return $this->escala;
    }

    /**
     * @param Escala $escala
     */
    public function setEscala(Escala $escala)
    {
        $this->escala = $escala;
    }

}

