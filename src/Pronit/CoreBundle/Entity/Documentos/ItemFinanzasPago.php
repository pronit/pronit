<?php

namespace Pronit\CoreBundle\Entity\Documentos;

use Pronit\CoreBundle\Entity\Contabilidad\CuentasContables\Cuenta;
use Pronit\CoreBundle\Entity\Operaciones\OperacionContable;
use Doctrine\ORM\Mapping as ORM;

/**
 * Item de finanzas específico para una operación de pago en un documento.
 * 
 * Este tipo de items se generan cuando se utiliza un algoritmo en función
 * de una condición de pagos.
 *
 * @ORM\Entity
 * @author gcaseres
 */
class ItemFinanzasPago extends ItemFinanzas {
    
    /**
     *
     * @var int 
     */
    private $numeroPago;
    
    public function __construct($numeroPago, OperacionContable $operacion = null, Cuenta $cuenta = null) {
        parent::__construct($operacion, $cuenta);
        $this->numeroPago = $numeroPago;
    }
    
    public function accept(ItemFinanzasVisitor $visitor) {
        $visitor->visitItemFinanzasPago($this);
    }
    
    /**
     * 
     * @param int $value
     */
    public function setNumeroPago($value) {
        $this->numeroPago = $value;
    }
    
    /**
     * 
     * @return int
     */
    public function getNumeroPago() {
        return $this->numeroPago;
    }    
    

}
