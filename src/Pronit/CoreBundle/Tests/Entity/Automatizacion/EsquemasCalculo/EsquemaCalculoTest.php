<?php

namespace Pronit\CoreBundle\Tests\Entity\Automatizacion\EsquemasCalculo;

use Pronit\CoreBundle\Entity\Automatizacion\EsquemasCalculo\EsquemaCalculo;
use Pronit\CoreBundle\Entity\Automatizacion\EsquemasCalculo\ItemEsquemaCalculoTotalizador;

/**
 * Description of EsquemaCalculoTest
 *
 * @author gcaseres
 */
class EsquemaCalculoTest extends \PHPUnit_Framework_TestCase {

    public function testAddItem() {
        $esquemaCalculo = new EsquemaCalculo();
        $esquemaCalculo->addItem(new ItemEsquemaCalculoTotalizador());

        $this->assertEquals($esquemaCalculo->getItems()->count(), 1);

        $esquemaCalculo->addItem(new ItemEsquemaCalculoTotalizador());

        $this->assertEquals($esquemaCalculo->getItems()->count(), 2);

        $this->assertEquals(0, $esquemaCalculo->getItems()->offsetGet(0)->getOrden());
        $this->assertEquals(1, $esquemaCalculo->getItems()->offsetGet(1)->getOrden());
    }

    public function testRemoveItem() {
        $item1 = $this->getMock('Pronit\CoreBundle\Entity\Automatizacion\EsquemasCalculo\ItemEsquemaCalculo', array('calcular'));
        $item2 = $this->getMock('Pronit\CoreBundle\Entity\Automatizacion\EsquemasCalculo\ItemEsquemaCalculo', array('calcular'));
        $item3 = $this->getMock('Pronit\CoreBundle\Entity\Automatizacion\EsquemasCalculo\ItemEsquemaCalculo', array('calcular'));

        $esquemaCalculo = new EsquemaCalculo();
        $esquemaCalculo->addItem($item1);
        $esquemaCalculo->addItem($item2);
        $esquemaCalculo->addItem($item3);

        $esquemaCalculo->removeItem(1);

        $this->assertEquals(0, $item1->getOrden());
        $this->assertEquals(1, $item3->getOrden());
        $this->assertEquals(2, $esquemaCalculo->getItems()->count());

        $esquemaCalculo->removeItem(1);

        $this->assertEquals(0, $item1->getOrden());
        $this->assertEquals(1, $esquemaCalculo->getItems()->count());

        $esquemaCalculo->removeItem(0);

        $this->assertEquals(0, $esquemaCalculo->getItems()->count());
    }

    public function testMoverItem() {
        $item0 = $this->getMock('Pronit\CoreBundle\Entity\Automatizacion\EsquemasCalculo\ItemEsquemaCalculo', array('calcular'));
        $item1 = $this->getMock('Pronit\CoreBundle\Entity\Automatizacion\EsquemasCalculo\ItemEsquemaCalculo', array('calcular'));
        $item2 = $this->getMock('Pronit\CoreBundle\Entity\Automatizacion\EsquemasCalculo\ItemEsquemaCalculo', array('calcular'));
        $item3 = $this->getMock('Pronit\CoreBundle\Entity\Automatizacion\EsquemasCalculo\ItemEsquemaCalculo', array('calcular'));

        $esquemaCalculo = new EsquemaCalculo();
        $esquemaCalculo->addItem($item0);
        $esquemaCalculo->addItem($item1);
        $esquemaCalculo->addItem($item2);
        $esquemaCalculo->addItem($item3);

        $esquemaCalculo->moverItem($item2, 1);

        $this->assertEquals(0, $item0->getOrden());
        $this->assertEquals(1, $item2->getOrden());
        $this->assertEquals(2, $item1->getOrden());
        $this->assertEquals(3, $item3->getOrden());

        $this->assertEquals(4, $esquemaCalculo->getItems()->count());
    }

    public function testMoverItemAlPrincipio() {
        $item0 = $this->getMock('Pronit\CoreBundle\Entity\Automatizacion\EsquemasCalculo\ItemEsquemaCalculo', array('calcular'));
        $item1 = $this->getMock('Pronit\CoreBundle\Entity\Automatizacion\EsquemasCalculo\ItemEsquemaCalculo', array('calcular'));
        $item2 = $this->getMock('Pronit\CoreBundle\Entity\Automatizacion\EsquemasCalculo\ItemEsquemaCalculo', array('calcular'));
        $item3 = $this->getMock('Pronit\CoreBundle\Entity\Automatizacion\EsquemasCalculo\ItemEsquemaCalculo', array('calcular'));

        $esquemaCalculo = new EsquemaCalculo();
        $esquemaCalculo->addItem($item0);
        $esquemaCalculo->addItem($item1);
        $esquemaCalculo->addItem($item2);
        $esquemaCalculo->addItem($item3);

        $esquemaCalculo->moverItem($item2, 3);

        $this->assertEquals(0, $item0->getOrden());
        $this->assertEquals(1, $item1->getOrden());
        $this->assertEquals(2, $item3->getOrden());
        $this->assertEquals(3, $item2->getOrden());

        $this->assertEquals(4, $esquemaCalculo->getItems()->count());
    }

    public function testMoverItemAlFinal() {
        $item0 = $this->getMock('Pronit\CoreBundle\Entity\Automatizacion\EsquemasCalculo\ItemEsquemaCalculo', array('calcular'));
        $item1 = $this->getMock('Pronit\CoreBundle\Entity\Automatizacion\EsquemasCalculo\ItemEsquemaCalculo', array('calcular'));
        $item2 = $this->getMock('Pronit\CoreBundle\Entity\Automatizacion\EsquemasCalculo\ItemEsquemaCalculo', array('calcular'));
        $item3 = $this->getMock('Pronit\CoreBundle\Entity\Automatizacion\EsquemasCalculo\ItemEsquemaCalculo', array('calcular'));

        $esquemaCalculo = new EsquemaCalculo();
        $esquemaCalculo->addItem($item0);
        $esquemaCalculo->addItem($item1);
        $esquemaCalculo->addItem($item2);
        $esquemaCalculo->addItem($item3);

        $esquemaCalculo->moverItem($item2, 0);

        $this->assertEquals(0, $item2->getOrden());
        $this->assertEquals(1, $item0->getOrden());
        $this->assertEquals(2, $item1->getOrden());
        $this->assertEquals(3, $item3->getOrden());

        $this->assertEquals(4, $esquemaCalculo->getItems()->count());
    }

    public function testInsertItem() {
        $item0 = $this->getMock('Pronit\CoreBundle\Entity\Automatizacion\EsquemasCalculo\ItemEsquemaCalculo', array('calcular'));
        $item1 = $this->getMock('Pronit\CoreBundle\Entity\Automatizacion\EsquemasCalculo\ItemEsquemaCalculo', array('calcular'));
        $item2 = $this->getMock('Pronit\CoreBundle\Entity\Automatizacion\EsquemasCalculo\ItemEsquemaCalculo', array('calcular'));

        $esquemaCalculo = new EsquemaCalculo();
        $esquemaCalculo->insertItem($item0, 0);

        $this->assertEquals(1, $esquemaCalculo->getItems()->count());

        $esquemaCalculo->insertItem($item1, 0);

        $this->assertEquals(0, $item1->getOrden());
        $this->assertEquals(1, $item0->getOrden());
        $this->assertEquals(2, $esquemaCalculo->getItems()->count());

        $esquemaCalculo->insertItem($item2, 1);

        $this->assertEquals(0, $item1->getOrden());
        $this->assertEquals(1, $item2->getOrden());
        $this->assertEquals(2, $item0->getOrden());
        $this->assertEquals(3, $esquemaCalculo->getItems()->count());
    }

    public function testGetItems() {
        $item0 = $this->getMock('Pronit\CoreBundle\Entity\Automatizacion\EsquemasCalculo\ItemEsquemaCalculo', array('calcular'));
        $item1 = $this->getMock('Pronit\CoreBundle\Entity\Automatizacion\EsquemasCalculo\ItemEsquemaCalculo', array('calcular'));
        $item2 = $this->getMock('Pronit\CoreBundle\Entity\Automatizacion\EsquemasCalculo\ItemEsquemaCalculo', array('calcular'));

        $esquemaCalculo = new EsquemaCalculo();
        $esquemaCalculo->addItem($item0);
        $esquemaCalculo->addItem($item1);
        $esquemaCalculo->addItem($item2);
        $esquemaCalculo->removeItem(1);
        $esquemaCalculo->addItem($item1);


        $orden = 0;
        foreach ($esquemaCalculo->getItems() as $item) {
            $this->assertEquals($orden, $item->getOrden());
            $orden ++;
        }
    }

    public function testCalcular() {
        $contexto = $this->getMock('Pronit\CoreBundle\Model\Automatizacion\EsquemasCalculo\Contextos\ContextoEsquemaCalculo');
        
        $item0 = $this->getMock('Pronit\CoreBundle\Entity\Automatizacion\EsquemasCalculo\ItemEsquemaCalculo', array('calcular'));
        $item0->expects($this->once())
                ->method('calcular');

        $item1 = $this->getMock('Pronit\CoreBundle\Entity\Automatizacion\EsquemasCalculo\ItemEsquemaCalculo', array('calcular'));
        $item1->expects($this->once())
                ->method('calcular');

        $item2 = $this->getMock('Pronit\CoreBundle\Entity\Automatizacion\EsquemasCalculo\ItemEsquemaCalculo', array('calcular'));
        $item2->expects($this->once())
                ->method('calcular');

        $esquemaCalculo = new EsquemaCalculo();
        $esquemaCalculo->addItem($item0);
        $esquemaCalculo->addItem($item1);
        $esquemaCalculo->addItem($item2);

        $resultado = $esquemaCalculo->calcular($contexto);
        
        $this->assertNotNull($resultado);
        
    }

}
