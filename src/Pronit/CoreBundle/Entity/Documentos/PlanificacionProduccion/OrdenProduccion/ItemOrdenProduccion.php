<?php

namespace Pronit\CoreBundle\Entity\Documentos\PlanificacionProduccion\OrdenProduccion;


use Doctrine\ORM\Mapping as ORM;

use Pronit\CoreBundle\Entity\Documentos\Item;
use Pronit\GestionBienesYServiciosBundle\Entity\Material;

abstract class ItemOrdenProduccion extends Item
{
    /**
     * @ORM\ManyToOne(targetEntity="Pronit\GestionBienesYServiciosBundle\Entity\Material")
     */
    protected $material;

    /**
     * @return Material
     */
    public function getMaterial()
    {
        return $this->material;
    }

    /**
     * @param Material $material
     */
    public function setMaterial(Material $material)
    {
        $this->material = $material;
    }
}

