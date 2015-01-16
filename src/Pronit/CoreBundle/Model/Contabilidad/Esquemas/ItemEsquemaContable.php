<?php

namespace Pronit\CoreBundle\Model\Contabilidad\Esquemas;

use Pronit\CoreBundle\Entity\Contabilidad\CuentasContables\Cuenta;
use Pronit\CoreBundle\Entity\Documentos\Item;
use Pronit\CoreBundle\Entity\Operaciones\OperacionContable;


class ItemEsquemaContable
{
    /** @var Item */
    protected $itemDocumento;
    
    /** @var OperacionContable */
    protected $operacion;
    
    /** @var Cuenta */
    protected $cuenta;
    
    /** @var float */
    protected $monto;
    
    public function __construct( Item $itemDocumento, OperacionContable $operacion, Cuenta $cuenta, $monto )
    {
        $this->setCuenta($cuenta);
        $this->setItemDocumento($itemDocumento);
        $this->setMonto($monto);
        $this->setOperacion($operacion);
    }
    
    /**
     * 
     * @return Item
     */
    public function getItemDocumento()
    {
        return $this->itemDocumento;
    }

    /**
     * 
     * @return OperacionContable
     */
    public function getOperacion()
    {
        return $this->operacion;
    }

    
    /**
     * 
     * @return Cuenta
     */
    public function getCuenta()
    {
        return $this->cuenta;
    }

    public function getMonto()
    {
        return $this->monto;
    }

    public function setItemDocumento($itemDocumento)
    {
        $this->itemDocumento = $itemDocumento;
    }

    public function setOperacion($operacion)
    {
        $this->operacion = $operacion;
    }

    public function setCuenta($cuenta)
    {
        $this->cuenta = $cuenta;
    }

    public function setMonto($monto)
    {
        $this->monto = $monto;
    }    
}
