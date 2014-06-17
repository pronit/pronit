<?php

namespace Pronit\ContabilidadBundle\Model\Esquemas;

use Pronit\CoreBundle\Entity\Operaciones\Operacion;
use Pronit\ContabilidadBundle\Entity\CuentasContables\Cuenta;
use Pronit\CoreBundle\Entity\Documentos\Item;

class ItemEsquemaContable
{
    protected $itemDocumento;
    protected $operacion;
    protected $cuenta;    
    protected $monto;
    
    public function __construct( Item $itemDocumento, Operacion $operacion, Cuenta $cuenta, $monto )
    {
        $this->setCuenta($cuenta);
        $this->setItemDocumento($itemDocumento);
        $this->setMonto($monto);
        $this->setOperacion($operacion);
    }
    
    public function getItemDocumento()
    {
        return $this->itemDocumento;
    }

    public function getOperacion()
    {
        return $this->operacion;
    }

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
