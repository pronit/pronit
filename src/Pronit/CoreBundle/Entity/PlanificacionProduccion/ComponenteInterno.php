<?php

namespace Pronit\CoreBundle\Entity\PlanificacionProduccion;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 */
class ComponenteInterno extends Componente
{
    /**
     * @ORM\ManyToOne(targetEntity="Pronit\CoreBundle\Entity\PlanificacionProduccion\VersionFabricacion")
     * @var VersionFabricacion
     */
    protected $versionFabricacion;

    /**
     * @return VersionFabricacion
     */
    public function getVersionFabricacion()
    {
        return $this->versionFabricacion;
    }

    /**
     * @param VersionFabricacion $versionFabricacion
     */
    public function setVersionFabricacion(VersionFabricacion $versionFabricacion)
    {
        $this->versionFabricacion = $versionFabricacion;
    }
    
}