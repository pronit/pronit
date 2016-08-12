<?php

namespace Pronit\CoreBundle\Entity\PlanificacionProduccion;

use Doctrine\ORM\Mapping as ORM;
use Pronit\GestionBienesYServiciosBundle\Entity\Material;
use Pronit\CoreBundle\Entity\PlanificacionProduccion\ListaMateriales;

/**
 * @ORM\Entity
 */
class ComponenteExterno extends Componente
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