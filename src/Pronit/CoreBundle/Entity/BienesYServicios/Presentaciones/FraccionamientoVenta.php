<?php

namespace Pronit\CoreBundle\Entity\BienesYServicios\Presentaciones;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="core_bienesyservicios_fraccionamientosventa") 
 */
class FraccionamientoVenta extends Fraccionamiento
{
    /**
     * @ORM\OneToOne(targetEntity="Pronit\CoreBundle\Entity\BienesYServicios\Presentaciones\PresentacionVenta", inversedBy="fraccionamientoVentaDestino")
     */        
    private $presentacionOrigen;
    
    /**
     * @ORM\OneToOne(targetEntity="Pronit\CoreBundle\Entity\BienesYServicios\Presentaciones\PresentacionVenta", inversedBy="fraccionamientoVentaOrigen")
     */        
    private $presentacionDestino;
    
    function getPresentacionOrigen() 
    {
        return $this->presentacionOrigen;
    }

    function getPresentacionDestino() 
    {
        return $this->presentacionDestino;
    }

    function setPresentacionOrigen(PresentacionVenta $presentacionOrigen) 
    {
        $this->presentacionOrigen = $presentacionOrigen;
    }

    function setPresentacionDestino(PresentacionVenta $presentacionDestino) 
    {
        $this->presentacionDestino = $presentacionDestino;
    }
}
