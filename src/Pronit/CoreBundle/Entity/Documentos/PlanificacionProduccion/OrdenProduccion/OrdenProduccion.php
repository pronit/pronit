<?php

namespace Pronit\CoreBundle\Entity\Documentos\PlanificacionProduccion\OrdenProduccion;

use Doctrine\ORM\Mapping as ORM;

use Pronit\CoreBundle\Entity\PlanificacionProduccion\VersionFabricacion;
use Pronit\ParametrizacionGeneralBundle\Entity\Escala;

use Pronit\CoreBundle\Entity\Documentos\Documento;

/**
 * Class OrdenProduccion
 * @package Pronit\CoreBundle\Entity\Documentos\PlanificacionProduccion
 * @ORM\Entity
 */
class OrdenProduccion extends Documento
{
    /**
     * @ORM\ManyToOne(targetEntity="Pronit\ParametrizacionGeneralBundle\Entity\Escala")
     */
    protected $escala;
    
    /**
     * @ORM\ManyToOne(targetEntity="Pronit\CoreBundle\Entity\PlanificacionProduccion\VersionFabricacion")
     */
    protected $versionFabricacion;

    /**
     * @ORM\Column(type="float")
     */
    protected $cantidadBase;

    public function __construct()
    {
        parent::__construct();
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

    /**
     * @return float
     */
    public function getCantidadBase()
    {
        return $this->cantidadBase;
    }

    /**
     * @param float $cantidadBase
     */
    public function setCantidadBase($cantidadBase)
    {
        $this->cantidadBase = $cantidadBase;
    }

    public function getItemsMaterialDirecto()
    {
        $subitems = new \Doctrine\Common\Collections\ArrayCollection();

        foreach( $this->getItems() as $item ){
            if ('Pronit\CoreBundle\Entity\Documentos\PlanificacionProduccion\OrdenProduccion\ItemMaterialDirecto' === get_class($item)){
                $subitems->add($item);
            }
        }
        return $subitems;
    }

    public function getItemsCostoIndirecto()
    {
        $subitems = new \Doctrine\Common\Collections\ArrayCollection();

        foreach( $this->getItems() as $item ){
            if ('Pronit\CoreBundle\Entity\Documentos\PlanificacionProduccion\OrdenProduccion\ItemCostoIndirecto' === get_class($item)){
                $subitems->add($item);
            }
        }
        return $subitems;
    }
}

