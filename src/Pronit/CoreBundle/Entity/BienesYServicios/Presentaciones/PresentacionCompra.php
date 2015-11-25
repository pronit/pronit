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
     * @ORM\OneToMany(targetEntity="Pronit\CoreBundle\Entity\BienesYServicios\Presentaciones\Fraccionamiento", mappedBy="presentacionCompra", cascade={"ALL"})
     */    
    protected $fraccionamientos;    
    
    public function __construct()
    {
        $this->setFraccionamientos( new ArrayCollection() );
    }    
    
    function getFraccionamientos() 
    {
        return $this->fraccionamientos;
    }

    function setFraccionamientos($fraccionamientos) {
        $this->fraccionamientos = $fraccionamientos;
    }
    
    public function addFraccionamiento(Fraccionamiento $fraccionamiento)
    {
        $fraccionamiento->setPresentacionCompra($this);
        $this->fraccionamientos[] = $fraccionamiento;
    }

    public function removeFraccionamiento(Fraccionamiento $fraccionamiento)
    {
        $this->fraccionamientos->removeElement( $fraccionamiento  );
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
