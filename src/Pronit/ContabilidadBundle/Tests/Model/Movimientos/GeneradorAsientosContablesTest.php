<?php

use Pronit\ContabilidadBundle\Entity\CuentasContables\Cuenta;
use Pronit\ContabilidadBundle\Model\Esquemas\EsquemaContable;
use Pronit\ContabilidadBundle\Model\Esquemas\ItemEsquemaContable;
use Pronit\ContabilidadBundle\Model\Movimientos\GeneradorAsientosContables;
use Pronit\CoreBundle\Entity\Contabilidad\ClaveContabilizacion;
use Pronit\CoreBundle\Entity\Operaciones\OperacionContable;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

/**
 * Description of GeneradorAsientosContablesTest
 *
 * @author gcaseres
 */
class GeneradorEsquemaContableTest extends KernelTestCase {
    
    public function testGenerarDesdeEsquema() {
        $cuenta1 = new Cuenta();
        $cuenta1->setNombre("Cuenta-1");

        $cuenta2 = new Cuenta();
        $cuenta2->setNombre("Cuenta-2");
        
        
        $claveContabilizacion1 = new ClaveContabilizacion();
        $claveContabilizacion1->setSigno(1);

        $claveContabilizacion2 = new ClaveContabilizacion();
        $claveContabilizacion2->setSigno(-1);
        
        $operacionContable1 = new OperacionContable();
        $operacionContable1->setClaveContabilizacion($claveContabilizacion1);

        $operacionContable2 = new OperacionContable();
        $operacionContable2->setClaveContabilizacion($claveContabilizacion2);
        
        $itemDocumento = $this->getMock('Pronit\CoreBundle\Entity\Documentos\Item');
        
        $esquema = new EsquemaContable();
        $esquema->addItem(new ItemEsquemaContable($itemDocumento, $operacionContable1, $cuenta1, 100));
        $esquema->addItem(new ItemEsquemaContable($itemDocumento, $operacionContable2, $cuenta2, 100));
        
        $generador = new GeneradorAsientosContables();
        $movimientos = $generador->generarDesdeEsquema($esquema);
        
        $this->assertEquals(2, $movimientos->count());
        
        $this->assertEquals(100, $movimientos[0]->getImporte());
        $this->assertEquals(-100, $movimientos[1]->getImporte());
    }
}
