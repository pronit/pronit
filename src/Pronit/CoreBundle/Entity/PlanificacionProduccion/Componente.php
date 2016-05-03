<?php
/**
 * Created by PhpStorm.
 * User: Lisandro
 * Date: 27/04/2016
 * Time: 22:56
 */

namespace Pronit\CoreBundle\Entity\PlanificacionProduccion;

use Doctrine\ORM\Mapping as ORM;
use Pronit\GestionBienesYServiciosBundle\Entity\Material;
use Pronit\CoreBundle\Entity\PlanificacionProduccion\ListaMateriales;

/**
 * @ORM\Entity
 * @ORM\Table(name="planificacion_componente")
 * @ORM\InheritanceType("SINGLE_TABLE")
 * @ORM\DiscriminatorColumn(name="discr", type="string")
 * @ORM\DiscriminatorMap({"ComponenteInternoValue" = "Pronit\CoreBundle\Entity\PlanificacionProduccion\ComponenteInterno", "ComponenteExternoValue" = "Pronit\CoreBundle\Entity\PlanificacionProduccion\ComponenteExterno"})
 * Componente Interno/Externo (Interno tiene una relación con VersionFabricacion)
 */
abstract class Componente
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="float")
     */
    protected $cantidad;

    /**
     * @ORM\ManyToOne(targetEntity="Pronit\CoreBundle\Entity\PlanificacionProduccion\ListaMateriales", inversedBy="componentes")
     */
    protected $listaMateriales;

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
}