<?php

namespace Pronit\CoreBundle\Entity\BienesYServicios\Presentaciones;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\MappedSuperclass
 */
abstract class Fraccionamiento
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
    private $cantidad;    
    
    /**
     * @ORM\ManyToOne(targetEntity="Pronit\ParametrizacionGeneralBundle\Entity\Escala", inversedBy="escala")
     */        
    private $unidad;   
    
    
    function getCantidad() 
    {
        return $this->cantidad;
    }

    function setCantidad($cantidad) 
    {
        $this->cantidad = $cantidad;
    }
    
    function getUnidad() 
    {
        return $this->unidad;
    }

    function setUnidad($unidad) 
    {
        $this->unidad = $unidad;
    }    
    
    function getPresentacionOrigen() 
    {
        return $this->presentacionOrigen;
    }

    function getPresentacionDestino() 
    {
        return $this->presentacionDestino;
    }

    function setPresentacionDestino( PresentacionVenta $presentacionVenta) 
    {
        $this->presentacionDestino = $presentacionVenta;
    }    
}
