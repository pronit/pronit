<?php

namespace Pronit\CoreBundle\Entity\PlanificacionProduccion;

use Doctrine\ORM\Mapping as ORM;
use Pronit\CoreBundle\Entity\PlanificacionProduccion\Componente;
use Pronit\GestionBienesYServiciosBundle\Entity\Material;

/**
 * @ORM\Entity
 * @ORM\Table(name="planificacion_listamateriales")
 */
class ListaMateriales
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\ManyToOne(targetEntity="Pronit\GestionBienesYServiciosBundle\Entity\Material")
     */
    protected $material;

    /**
     * @ORM\OneToMany(targetEntity="Pronit\CoreBundle\Entity\PlanificacionProduccion\Componente", cascade={"ALL"}, mappedBy="listaMateriales")
     */
    protected $componentes;

    public function __construct() {
        $this->componentes = new \Doctrine\Common\Collections\ArrayCollection();
    }

    public function getId()
    {
        return $this->id;
    }

    /**
     * @param \Pronit\CoreBundle\Entity\PlanificacionProduccion\Componente $componente
     */
    public function addComponente(Componente $componente)
    {
        $componente->setListaMateriales($this);
        $this->componentes[] = $componente;
    }


    public function removeComponente(Componente $componente)
    {
        $this->componentes->removeElement($componente);
    }

    public function getComponentes()
    {
        return $this->componentes;
    }

    public function getComponentesInternos()
    {
        $componentesInternos = new \Doctrine\Common\Collections\ArrayCollection();

        foreach( $this->getComponentes() as $item ){
            if ('Pronit\CoreBundle\Entity\PlanificacionProduccion\ComponenteInterno' === get_class($item)){
                $componentesInternos->add($item);
            }
        }
        return $componentesInternos;
    }

    public function getComponentesExternos()
    {
        $componentesExternos = new \Doctrine\Common\Collections\ArrayCollection();

        foreach( $this->getComponentes() as $item ){
            if ('Pronit\CoreBundle\Entity\PlanificacionProduccion\ComponenteExterno' === get_class($item)){
                $componentesExternos->add($item);
            }
        }
        return $componentesExternos;
    }
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

    public function __toString()
    {
        return $this->getMaterial()->getNombre();
    }
}
