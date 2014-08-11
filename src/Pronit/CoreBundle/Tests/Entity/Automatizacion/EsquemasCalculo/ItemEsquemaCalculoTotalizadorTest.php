<?php

namespace Pronit\CoreBundle\Tests\Entity\Automatizacion\EsquemasCalculo;

use Pronit\CoreBundle\Entity\Automatizacion\EsquemasCalculo\EsquemaCalculo;
use Pronit\CoreBundle\Entity\Automatizacion\EsquemasCalculo\ItemEsquemaCalculoTotalizador;
use Pronit\CoreBundle\Entity\Automatizacion\EsquemasCalculo\ResultadoCalculo;
use Pronit\CoreBundle\Model\Automatizacion\EsquemasCalculo\Contextos\ContextoEsquemaCalculo;
use Pronit\CoreBundle\Model\Automatizacion\EsquemasCalculo\Contextos\ContextoItemEsquemaCalculo;

/**
 * Description of EsquemaCalculoTest
 *
 * @author gcaseres
 */
class ItemEsquemaCalculoTotalizadorTest extends \PHPUnit_Framework_TestCase {

    public function testCalcular() {
        
        $item = new ItemEsquemaCalculoTotalizador();
        
        $item->addReferencia(0, 2);
        $item->addReferencia(5, 6);
        

        $resultado = new ResultadoCalculo();
        $resultado->addCondicion("Condición 1", 10);
        $resultado->addCondicion("Condición 2", 20);
        $resultado->addCondicion("Condición 3", 50);


        $contexto = new ContextoEsquemaCalculo();
        $contextoItem = new ContextoItemEsquemaCalculo($contexto, $item, $resultado);

        $item->calcular($contextoItem, $resultado);

        $this->assertEquals(4, $resultado->getCondicionesCount());
        $this->assertEquals(80, $resultado->getCondicion(3)->getValor());
    }

}
