<?php

namespace Pronit\ComprasBundle\Entity\Documentos\OrdenesPago;

use Doctrine\ORM\Mapping as ORM;

use \Exception;

use Pronit\CoreBundle\Entity\Contabilidad\CuentasContables\Cuenta;

/**
 *
 * @author ldelia
 * @ORM\Entity
 * @ORM\InheritanceType("SINGLE_TABLE")
 * @ORM\DiscriminatorColumn(name="discr", type="string")
 * @ORM\DiscriminatorMap({
        "ItemPagoEfectivoValue" = "Pronit\ComprasBundle\Entity\Documentos\OrdenesPago\ItemPagoEfectivo",
        "ItemPagoTransferenciaBancariaValue" = "Pronit\ComprasBundle\Entity\Documentos\OrdenesPago\ItemPagoTransferenciaBancaria",
    })
 */
abstract class ItemPago
{    
   /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;    
    
    /** 
     * @ORM\ManyToOne(targetEntity="OrdenPago", inversedBy="itemsPago") 
     */
    protected $ordenPago;
    
    /** 
     * @ORM\Column(type="float") 
     */
    protected $importe;    
    
    /**
     * @ORM\ManyToOne(targetEntity="Pronit\CoreBundle\Entity\Contabilidad\CuentasContables\Cuenta")
     * @ORM\JoinColumn(nullable=false)
     */    
    protected $cuenta;    

    function getOrdenPago()
    {
        return $this->ordenPago;
    }

    function setOrdenPago($ordenPago)
    {
        $this->ordenPago = $ordenPago;
    }
    
    function getImporte()
    {
        return $this->importe;
    }

    function setImporte($importe)
    {
        $this->importe = $importe;
    }    
    
    function getCuenta()
    {
        return $this->cuenta;
    }

    function setCuenta(Cuenta $cuenta)
    {
        $this->cuenta = $cuenta;
    }    
}
