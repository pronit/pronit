<?php

namespace Pronit\CoreBundle\Entity\BienesYServicios\Presentaciones;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="core_bienesyservicios_fraccionamientos") 
 */
class Fraccionamiento
{
    /**
     * @ORM\Column(type="integer")  
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */    
    protected $id;    
    
    /**
     * @ORM\ManyToOne(targetEntity="Pronit\CoreBundle\Entity\BienesYServicios\Presentaciones\PresentacionCompra", inversedBy="fraccionamientos")
     */        
    private $presentacionCompra;        
    
    /**
     * @ORM\Column(type="float")
     */        
    private $cantidad;
    
    /**
     * @ORM\ManyToOne(targetEntity="Pronit\ParametrizacionGeneralBundle\Entity\Escala", inversedBy="escala")
     */        
    private $escala;    
    
    /**
     * @ORM\ManyToOne(targetEntity="Pronit\CoreBundle\Entity\BienesYServicios\Presentaciones\PresentacionVenta")
     */        
    private $presentacionVenta;
    
    
    function getPresentacionCompra() 
    {
        return $this->presentacionCompra;
    }

    function getCantidad() 
    {
        return $this->cantidad;
    }

    function setPresentacionCompra($presentacionCompra) 
    {
        $this->presentacionCompra = $presentacionCompra;
    }

    function setCantidad($cantidad) 
    {
        $this->cantidad = $cantidad;
    }

    function getEscala() 
    {
        return $this->escala;
    }

    function setEscala($escala) 
    {
        $this->escala = $escala;
    }    
    
    function getPresentacionVenta() 
    {
        return $this->presentacionVenta;
    }

    function setPresentacionVenta($presentacionVenta) 
    {
        $this->presentacionVenta = $presentacionVenta;
    }    
}
