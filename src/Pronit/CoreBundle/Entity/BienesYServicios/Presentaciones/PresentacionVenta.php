<?php

namespace Pronit\CoreBundle\Entity\BienesYServicios\Presentaciones;

use Doctrine\ORM\Mapping as ORM;

use Doctrine\Common\Collections\ArrayCollection;
use Pronit\ParametrizacionGeneralBundle\Entity\Escala;

/**
 * @ORM\Entity
 * @ORM\Table(name="core_bienesyservicios_presentacionesventa") 
 */
class PresentacionVenta
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */    
    protected $id;    
     
    /**
     * @ORM\ManyToOne(targetEntity="Pronit\GestionBienesYServiciosBundle\Entity\Material", inversedBy="presentacionesVenta")
     */        
    private $material;
    
    /**
     * @ORM\Column(type="string", length=50)
     */        
    private $nombre;    
    
    /**
     * @ORM\ManyToMany(targetEntity="Pronit\ParametrizacionGeneralBundle\Entity\Escala")
     */    
    protected $escalas;
    
    
    public function __construct()
    {
        $this->escalas = new ArrayCollection();
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
    
    function getEscalas() 
    {
        return $this->escalas;
    }

    function setEscalas($escalas) {
        $this->escalas = $escalas;
    }
    
    public function addEscala(Escala $escala)
    {
        $this->escalas[] = $escala;
    }

    public function removeEscala(Escala $escala)
    {
        $this->escalas->removeElement( $escala );
    }        
}
