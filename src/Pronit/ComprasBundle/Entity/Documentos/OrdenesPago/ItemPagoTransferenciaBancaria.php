<?php

namespace Pronit\ComprasBundle\Entity\Documentos\OrdenesPago;

use Doctrine\ORM\Mapping as ORM;

use Pronit\ParametrizacionGeneralBundle\Entity\Bancos\CuentaBancaria;

/**
 *
 * @author ldelia
 * @ORM\Entity
 */
class ItemPagoTransferenciaBancaria extends ItemPago
{    
    /**
     * @ORM\ManyToOne(targetEntity="Pronit\ParametrizacionGeneralBundle\Entity\Bancos\CuentaBancaria")
     */    
    protected $cuentaBancaria; 

    function getCuentaBancaria()
    {
        return $this->cuentaBancaria;
    }

    function setCuentaBancaria(CuentaBancaria $cuentaBancaria)
    {
        $this->cuentaBancaria = $cuentaBancaria;
    }    
    
}
