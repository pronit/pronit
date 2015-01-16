<?php

namespace Pronit\CoreBundle\Entity\Personas;

use Doctrine\ORM\Mapping as ORM;

use Pronit\CoreBundle\Entity\Contabilidad\CuentasContables\Cuenta;

abstract class Acreedor extends RolPersona
{
    /**
     * @ORM\ManyToOne(targetEntity="Pronit\CoreBundle\Entity\Contabilidad\CuentasContables\Cuenta")
     */    
    protected $cuenta;    
    
    function getCuenta()
    {
        return $this->cuenta;
    }

    function setCuenta(Cuenta $cuenta)
    {
        $this->cuenta = $cuenta;
    }    
    
}