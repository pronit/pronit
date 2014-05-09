<?php
namespace Pronit\CoreBundle\Tests\Entity\Operaciones;

use Pronit\CoreBundle\Entity\Operaciones\Operacion;

/**
 * Description of OperacionPrueba
 *
 * @author gcaseres
 */
class OperacionPrueba extends Operacion {
    
    public function __construct() {
        
    }
    
    protected function procesar($returnValue) {
        if (is_float($returnValue) || is_int($returnValue)) {
            return $returnValue;
        } else {
            return $this->procesarException(new \Exception("El tipo de retorno no es correcto para esta operación."));
        }
    }
    
    protected function procesarException(\Exception $e) {
        throw $e;
    }
}
