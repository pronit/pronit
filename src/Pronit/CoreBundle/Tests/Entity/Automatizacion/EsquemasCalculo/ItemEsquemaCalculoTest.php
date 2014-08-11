<?php

namespace Pronit\CoreBundle\Tests\Entity\Automatizacion\EsquemasCalculo;

use Iterator;

/**
 * Description of ItemEsquemaCalculoTest
 *
 * @author gcaseres
 */
class ItemEsquemaCalculoTest extends \PHPUnit_Framework_TestCase {

    public function testAddReferencia() {
        $item0 = $this->getMock('Pronit\CoreBundle\Entity\Automatizacion\EsquemasCalculo\ItemEsquemaCalculo', array('calcular'));        
        $item0->addReferencia(0, 10);
        
        $this->assertEquals(1, $item0->getReferenciasCount());        
        
        /* @var $it Iterator */
        $it = $item0->getReferencias();
        $this->assertEquals(array(0, 10), $it->current());
    }    
    
    public function testRemoveReferencia() {
        $item0 = $this->getMock('Pronit\CoreBundle\Entity\Automatizacion\EsquemasCalculo\ItemEsquemaCalculo', array('calcular'));
                
        $item0->addReferencia(0, 10);
        $item0->addReferencia(11, 20);
        $item0->addReferencia(21, 30);
        
        $item0->removeReferencia(1);
        
        $this->assertEquals(2, $item0->getReferenciasCount());        

        $item0->removeReferencia(0);
        
        $this->assertEquals(1, $item0->getReferenciasCount());                
        
        $item0->removeReferencia(0);
        
        $this->assertEquals(0, $item0->getReferenciasCount());                
    }        
}
