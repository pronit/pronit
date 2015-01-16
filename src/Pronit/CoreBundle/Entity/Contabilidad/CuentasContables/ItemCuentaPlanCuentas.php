<?php

namespace Pronit\CoreBundle\Entity\Contabilidad\CuentasContables;

use Doctrine\ORM\Mapping as ORM;

/**
 *
 * @author ldelia 
 * @ORM\Entity
*/
class ItemCuentaPlanCuentas extends ItemPlanCuentas
{
    /**
     * @ORM\ManyToOne(targetEntity="Pronit\CoreBundle\Entity\Contabilidad\CuentasContables\Cuenta")
     * @ORM\JoinColumn(nullable=false)
     */    
    protected $cuenta;    

    public function getCuenta()
    {
        return $this->cuenta;
    }

    public function setCuenta(Cuenta $cuenta)
    {
        $this->cuenta = $cuenta;
    }
}

