<?php

namespace Pronit\CoreBundle\Entity\Personas;

use Doctrine\ORM\Mapping as ORM;

use Pronit\CoreBundle\Entity\Contabilidad\CuentasContables\Cuenta;    

/** 
 * @ORM\Entity
 */
class Deudor extends Acreedor
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

    public function __toString(){
        return (string) $this->getPersona();
    }
}
