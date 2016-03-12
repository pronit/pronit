<?php

namespace Pronit\CoreBundle\Tests\Model\Contabilidad\Movimientos;

use Pronit\ComprasBundle\Entity\Documentos\EntradasMercancias\EntradaMercancias;
use Pronit\ComprasBundle\Entity\Documentos\EntradasMercancias\ItemEntradaMercancias;
use Pronit\CoreBundle\Entity\Contabilidad\CuentasContables\Cuenta;
use Pronit\CoreBundle\Entity\Controlling\CentroCosto;
use Pronit\CoreBundle\Entity\Controlling\Imputacion;
use Pronit\CoreBundle\Entity\Controlling\ItemImputacion;
use Pronit\CoreBundle\Entity\Documentos\ItemFinanzas;
use Pronit\CoreBundle\Entity\Operaciones\OperacionContable;
use Pronit\CoreBundle\Model\Aspectos\IAspectoManager;
use Pronit\CoreBundle\Model\Documentos\Controlling\ImputadorObjetosCosto;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

/**
 * Description of GeneradorAsientosContablesTest
 *
 * @author gcaseres
 */
class ImputadorObjetosCostoTest extends KernelTestCase {

    public function testImputar() {

        /* @var $imputaObjetoCostosAspectoManagerMock IAspectoManager */
        $imputaObjetoCostosAspectoManagerMock = $this->getMockBuilder('Pronit\CoreBundle\Model\Aspectos\IAspectoManager')->getMock();

        $imputaObjetoCostosAspectoManagerMock->method('has')
                ->will($this->returnValue(true));

        $imputador = new ImputadorObjetosCosto($imputaObjetoCostosAspectoManagerMock);

        $objetoCosto = new CentroCosto();

        $cuentaContable = new Cuenta('CC1', 'Cuenta contable 1');
        $operacion = new OperacionContable();

        $doc = new EntradaMercancias();
        $importeItem = 100;

        $item = new ItemEntradaMercancias();
        $item->setObjetoCosto($objetoCosto);        
        $doc->addItem($item);

        $doc->addItemFinanzas(new ItemFinanzas($operacion, $cuentaContable, $item, $importeItem));

        $imputador->imputar($doc);

        $this->assertEquals(1, $objetoCosto->getImputaciones()->count());
        
        /* @var $imputacion Imputacion */
        $imputacion = $objetoCosto->getImputaciones()->get(0);
                
        $this->assertEquals(1, $imputacion->getCuentaContable()->equals($cuentaContable));
        $this->assertEquals(1, $imputacion->getItems()->count());        
        
        $this->assertEquals($importeItem, $imputacion->getImporte());
    }

}
