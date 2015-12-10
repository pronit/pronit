<?php

namespace Pronit\CoreBundle\Entity\BienesYServicios\Presentaciones;

use Doctrine\ORM\Mapping as ORM;

use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity
 * @ORM\Table(name="core_bienesyservicios_presentacionescompra") 
 */
class PresentacionCompra 
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
     * @ORM\Column(type="string", length=50)
     */        
    private $nombre;
    
    /**
     * @ORM\OneToOne(targetEntity="Pronit\CoreBundle\Entity\BienesYServicios\Presentaciones\Fraccionamiento", cascade={"ALL"})
     */    
    protected $fraccionamiento;    
    
    public function __construct()
    {
    }    
    
    function getFraccionamiento() 
    {
        return $this->fraccionamiento;
    }

    function setFraccionamiento( Fraccionamiento $fraccionamiento) {
        $this->fraccionamiento = $fraccionamiento;
    }
    
    function getNombre() 
    {
        return $this->nombre;
    }

    function setNombre($nombre) 
    {
        $this->nombre = $nombre;
    }    
    
    function getMaterial() 
    {
        return $this->material;
    }

    function setMaterial($material) 
    {
        $this->material = $material;
    }

    
}
