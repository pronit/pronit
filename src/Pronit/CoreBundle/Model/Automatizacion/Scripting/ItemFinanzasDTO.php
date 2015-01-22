<?php

namespace Pronit\CoreBundle\Model\Automatizacion\Scripting;

use Pronit\CoreBundle\Entity\Contabilidad\CuentasContables\Cuenta;

/**
 * Description of ItemFinanzasDTO
 *
 * @author gcaseres
 */
class ItemFinanzasDTO {

    /**
     *
     * @var Cuenta
     */
    private $cuenta;

    /**
     *
     * @var float
     */
    private $importe;

    public function __construct(Cuenta $cuenta, $importe) {
        $this->cuenta = $cuenta;
        $this->importe = $importe;
    }

    /**
     * 
     * @param Cuenta $value
     */
    public function setCuenta(Cuenta $value) {
        $this->cuenta = $value;
    }

    /**
     * 
     * @return Cuenta
     */
    public function getCuenta() {
        return $this->cuenta;
    }

    /**
     * 
     * @param float $value
     */
    public function setImporte($value) {
        $this->importe = $value;
    }

    /**
     * 
     * @return float
     */
    public function getImporte() {
        return $this->importe;
    }

}
