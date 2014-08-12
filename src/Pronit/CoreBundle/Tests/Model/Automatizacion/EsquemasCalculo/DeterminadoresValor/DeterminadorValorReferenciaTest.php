<?php

namespace Pronit\CoreBundle\Tests\Model\Automatizacion\EsquemasCalculo\DeterminadoresValor;

use Pronit\CoreBundle\Entity\Automatizacion\EsquemasCalculo\EsquemaCalculo;
use Pronit\CoreBundle\Entity\Automatizacion\EsquemasCalculo\ResultadoCalculo;
use Pronit\CoreBundle\Model\Automatizacion\EsquemasCalculo\Contextos\ContextoEsquemaCalculo;
use Pronit\CoreBundle\Model\Automatizacion\EsquemasCalculo\Contextos\ContextoItemEsquemaCalculo;
use Pronit\CoreBundle\Model\Automatizacion\EsquemasCalculo\DeterminadoresValor\DeterminadorValorReferencia;

/**
 * Description of ItemEsquemaCalculoTest
 *
 * @author gcaseres
 */
class ClaseCondicionTest extends \PHPUnit_Framework_TestCase {
    
    public function testDeterminar() {
        $esquema = new EsquemaCalculo();
        
        $item0 = $this->getMock('Pronit\CoreBundle\Entity\Automatizacion\EsquemasCalculo\ItemEsquemaCalculo', array('calcular'));
        $esquema->addItem($item0);
        
        $resultadoParcial = new ResultadoCalculo();
        $resultadoParcial->addCondicion("Condición 1", 10);
        $resultadoParcial->addCondicion("Condición 2", 20);
        $resultadoParcial->addCondicion("Condición 3", 10);
        $resultadoParcial->addCondicion("Condición 4", 10);
        $resultadoParcial->addCondicion("Condición 5", 50);
        $resultadoParcial->addCondicion("Condición 6", 30);
        
        $item0->addReferencia(0, 2);
        $item0->addReferencia(5, 5);
        
        $contextoEsquema = new ContextoEsquemaCalculo();
        $contextoItemEsquema = new ContextoItemEsquemaCalculo($contextoEsquema, $item0, $resultadoParcial);
        
        $determinador = new DeterminadorValorReferencia();
                        
        $valorDeterminado = $determinador->determinar($contextoItemEsquema);
        
        $this->assertEquals(70, $valorDeterminado);
        
    }

}
