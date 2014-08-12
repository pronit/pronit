<?php

namespace Pronit\CoreBundle\Model\Automatizacion\EsquemasCalculo\Estrategias\OperacionAritmetica;

use InvalidArgumentException;

/**
 * Description of Operacion
 *
 * @author gcaseres
 */
abstract class Operacion {

    /**
     * Obtiene la cantidad de operandos que son requeridos para ejecutar la
     * operación de cáculo correctamente.
     * 
     * @return int Cantidad de operandos requeridos por la operación.
     */
    public abstract function getOperandosRequeridos();
    
    /**
     * 
     * @param array $operandos
     * @return float
     */
    public function calcular(array $operandos) {
        if (count($operandos) != $this->getOperandosRequeridos()) {
            throw new InvalidArgumentException("La cantidad de operandos especificada es incorrecta.");
        }
        
        return $this->doCalcular($operandos);
    }
    
    protected abstract function doCalcular(array $operandos);

    /**
     * 
     * @return string
     */
    public abstract function getClassId();
}
