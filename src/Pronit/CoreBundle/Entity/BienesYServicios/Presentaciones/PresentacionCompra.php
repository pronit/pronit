<?php

namespace Pronit\CoreBundle\Entity\BienesYServicios\Presentaciones;

use Doctrine\ORM\Mapping as ORM;

use Doctrine\Common\Collections\ArrayCollection;
use Pronit\GestionBienesYServiciosBundle\Entity\Material;

/**
 * @ORM\Entity
 * @ORM\Table(name="core_bienesyservicios_presentacionescompra") 
 */
class PresentacionCompra extends Presentacion
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */    
    protected $id;    
    
    /**
     * @ORM\ManyToOne(targetEntity="Pronit\GestionBienesYServiciosBundle\Entity\Material", inversedBy="presentacionesCompra")
     */        
    private $material;  
    
    /**
     * @ORM\OneToOne(targetEntity="Pronit\CoreBundle\Entity\BienesYServicios\Presentaciones\FraccionamientoCompra", cascade={"ALL"}, mappedBy="presentacionOrigen")
     */    
    protected $fraccionamiento;    
    
    public function __construct()
    {
    }

    function getNombre() 
    {
        return $this->nombre;
    }

    function setNombre($nombre) 
    {
        $this->nombre = $nombre;
    }

    /**
     * @return Material
     */
    function getMaterial() 
    {
        return $this->material;
    }

    function setMaterial($material) 
    {
        $this->material = $material;
    }

    function getFraccionamiento() 
    {
        return $this->fraccionamiento;
    }

    function setFraccionamiento(FraccionamientoCompra $fraccionamiento) 
    {
        $this->fraccionamiento = $fraccionamiento;
        $fraccionamiento->setPresentacionOrigen($this);
    }

    public function __toString()
    {
        return $this->getMaterial()->getNombre() . " - " . $this->getNombre();
    }
}
