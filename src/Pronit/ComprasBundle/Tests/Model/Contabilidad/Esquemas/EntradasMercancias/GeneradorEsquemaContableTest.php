<?php

namespace Pronit\ComprasBundle\Tests\Model\Contabilidad\Esquemas\EntradasMercancias;

use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

/**
 * Description of GeneradorEsquemaContableTest
 *
 * @author ldelia
 */
class GeneradorEsquemaContableTest extends KernelTestCase
{
    private $generadorEsquemaContable;
    private $em;
    
    public function setUp()
    {
        static::$kernel = static::createKernel();
        static::$kernel->boot();
        $this->generadorEsquemaContable = static::$kernel->getContainer()->get('pronit_compras_contabilidad_esquemas_entradasmercancias.generador_esquema_contable');
        $this->em = static::$kernel->getContainer()->get('doctrine')->getManager();
    }    
    
    public function testGenerar()
    {
        $entradaMercancias = $this->em->getRepository('Pronit\ComprasBundle\Entity\Documentos\EntradasMercancias\EntradaMercancias')->findOneByNumero("0001/1");
        if( ! $entradaMercancias ){
            throw new \Exception("Para testear el GeneradorEsquemaContable se necesita ");
        }
        
        /* @var $generadorEsquemaContable \Pronit\ComprasBundle\Model\Contabilidad\Esquemas\EntradasMercancias\GeneradorEsquemaContable */
        $generadorEsquemaContable = $this->generadorEsquemaContable;

        /* @var $esquemaContable \Pronit\CoreBundle\Model\Contabilidad\Esquemas\EsquemaContable */        
        $esquemaContable = $generadorEsquemaContable->generar( $entradaMercancias );
        
        $this->assertEquals( 12,  $esquemaContable->getItems()->count(), "Verificar los fixtures para asegurarse que se están utilizando las operaciones contables correctas.");
        
        
        
        echo "\n";
        foreach ($esquemaContable->getItems() as $item) {            
            echo $item->getOperacion()->getCodigo() . ' - ' . $item->getItemDocumento()->getBienServicio()->getCodigo() . " - " . $item->getCuenta()->getNombre() . " - " . $item->getMonto() * $item->getOperacion()->getClaveContabilizacion()->getSigno() . "\n";
        }
         
        
        $saldo = 0;
        foreach ($esquemaContable->getItems() as $item) {            
            $saldo += $item->getMonto() * $item->getOperacion()->getClaveContabilizacion()->getSigno();
        }
        
        $this->assertEquals(0, $saldo, "El saldo de un esquema contable debe dar cero. Verificar funcionamiento correcto de los scripts asociados a las operaciones y del customizing de las mismas.");
    }
}
