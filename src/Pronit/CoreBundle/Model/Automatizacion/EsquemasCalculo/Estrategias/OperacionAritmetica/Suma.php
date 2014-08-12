<?php

use Pronit\CoreBundle\Model\Automatizacion\EsquemasCalculo\Estrategias\OperacionAritmetica\Operacion;
namespace Pronit\CoreBundle\Model\Automatizacion\EsquemasCalculo\Estrategias\OperacionAritmetica;

/**
 * Description of Suma
 *
 * @author gcaseres
 */
class Suma extends Operacion {
    
    const CLASS_ID = "SUMA";
    
    const CANTIDAD_OPERANDOS = 2;
    
    protected function doCalcular(array $operandos) {
        return $operandos[0] + $operandos[1];
    }

    public function getClassId() {
        return self::CLASS_ID;
    }

    public function getOperandosRequeridos() {
        return self::CANTIDAD_OPERANDOS;
    }

}
