<?php

namespace Pronit\CoreBundle\Tests\Model\Automatizacion\EsquemasCalculo\Estrategias\OperacionAritmetica;

use InvalidArgumentException;

/**
 * Description of EsquemaCalculoTest
 *
 * @author gcaseres
 */
class OperacionTest extends \PHPUnit_Framework_TestCase {

    
    /**
     * @expectedException InvalidArgumentException
     */
    public function testCalcularConCantidadDeArgumentosInvalida() {
        $operacion = $this->getMock('Pronit\CoreBundle\Model\Automatizacion\EsquemasCalculo\Estrategias\OperacionAritmetica\Operacion', array('doCalcular', 'getOperandosRequeridos', 'getClassId'));
        
        $operacion->expects($this->once())
                ->method('getOperandosRequeridos')
                ->will($this->returnValue(2));
        
        $operacion->calcular(array(1,2,3));
    }
}
