<?php

namespace Pronit\CoreBundle\Entity\BienesYServicios\Presentaciones;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="core_bienesyservicios_fraccionamientoscompra") 
 */
class FraccionamientoCompra extends Fraccionamiento
{
    /**
     * @ORM\OneToOne(targetEntity="Pronit\CoreBundle\Entity\BienesYServicios\Presentaciones\PresentacionCompra", inversedBy="fraccionamiento")
     */        
    private $presentacionOrigen;
    
    /**
     * @ORM\ManyToOne(targetEntity="Pronit\CoreBundle\Entity\BienesYServicios\Presentaciones\PresentacionVenta", inversedBy="fraccionamientosCompra")
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

    function setPresentacionOrigen(PresentacionCompra $presentacionOrigen) 
    {
        $this->presentacionOrigen = $presentacionOrigen;
    }

    function setPresentacionDestino(PresentacionVenta $presentacionDestino) 
    {
        $this->presentacionDestino = $presentacionDestino;
    }
}
