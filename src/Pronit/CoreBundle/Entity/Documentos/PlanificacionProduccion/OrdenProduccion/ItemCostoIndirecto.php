<?php

namespace Pronit\CoreBundle\Entity\Documentos\PlanificacionProduccion\OrdenProduccion;


use Doctrine\ORM\Mapping as ORM;

use Pronit\CoreBundle\Entity\Controlling\ObjetoCosto;
use Pronit\CoreBundle\Entity\Documentos\Item;
use Pronit\ParametrizacionGeneralBundle\Entity\Escala;

/**
 * @package Pronit\CoreBundle\Entity\Documentos\PlanificacionProduccion
 * @ORM\Entity
 */
class ItemCostoIndirecto extends ItemOrdenProduccion
{
    /**
     * @ORM\Column(type="float")
     */
    protected $costoImputado;

    /**
     * @ORM\Column(type="float")
     */
    protected $porcentaje;

    /**
     * @ORM\ManyToOne(targetEntity="Pronit\CoreBundle\Entity\Controlling\ObjetoCosto")
     */
    protected $objetoCosto;

    /**
     * @return mixed
     */
    public function getCostoImputado()
    {
        return $this->costoImputado;
    }

    /**
     * @param $costoImputado
     */
    public function setCostoImputado($costoImputado)
    {
        $this->costoImputado = $costoImputado;
    }

    /**
     * @return mixed
     */
    public function getPorcentaje()
    {
        return $this->porcentaje;
    }

    /**
     * @param mixed $porcentaje
     */
    public function setPorcentaje($porcentaje)
    {
        $this->porcentaje = $porcentaje;
    }

    /**
     * @return ObjetoCosto
     */
    public function getObjetoCosto()
    {
        return $this->objetoCosto;
    }

    /**
     * @param ObjetoCosto $objetoCosto
     */
    public function setObjetoCosto(ObjetoCosto $objetoCosto)
    {
        $this->objetoCosto = $objetoCosto;
    }


}

