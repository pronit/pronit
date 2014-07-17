<?php

namespace Pronit\GestionBienesYServiciosBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * 
 *
 * @author ldelia
 * @ORM\Entity
 * @ORM\Table(name="gestionbienesyservicios_tipobienesservicios")
 * @ORM\InheritanceType("SINGLE_TABLE")
 * @ORM\DiscriminatorColumn(name="discr", type="string")
 * @ORM\DiscriminatorMap({"TipoMaterialValue" = "Pronit\GestionBienesYServiciosBundle\Entity\TipoMaterial", "TipoServicioValue" = "Pronit\GestionBienesYServiciosBundle\Entity\TipoServicio"})
 */
abstract class TipoBienServicio
{    
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */    
    protected $id;

    /**
     * @ORM\Column(type="string", length=30)
     */    
    protected $nombre;
    
    public function __construct()
    {
    }
    
    public function getId()
    {
        return $this->id;
    }
    
    public function setNombre($valor)
    {
        $this->nombre = $valor;
    }
    
    public function getNombre()
    {
        return $this->nombre;
    }

    public function __toString()
    {
        return $this->getNombre();            
    }   
}