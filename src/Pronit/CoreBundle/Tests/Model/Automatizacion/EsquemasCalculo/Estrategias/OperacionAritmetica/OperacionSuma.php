<?php

namespace Pronit\CoreBundle\Tests\Model\Automatizacion\EsquemasCalculo\Estrategias\OperacionAritmetica;

use InvalidArgumentException;
use Pronit\CoreBundle\Model\Automatizacion\EsquemasCalculo\Estrategias\OperacionAritmetica\Suma;

/**
 * Description of EsquemaCalculoTest
 *
 * @author gcaseres
 */
class OperacionSuma extends \PHPUnit_Framework_TestCase {

    /**
     * @expectedException InvalidArgumentException
     */
    public function testCalcularConCantidadDeArgumentosInvalida() {
        $operacion = new Suma();
        
        $operacion->calcular(array(1,2,3));
    }
    
    public function testCalcular() {
        $operacion = new Suma();
                
        $result = $operacion->calcular(array(1,5));
        
        $this->assertEquals(6, $result);
    }
}
