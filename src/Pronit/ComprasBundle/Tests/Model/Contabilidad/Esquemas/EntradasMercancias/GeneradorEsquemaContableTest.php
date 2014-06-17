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
        $entradaMercancias = $this->em->getRepository('Pronit\ComprasBundle\Entity\EntradasMercancias\EntradaMercancias')->findOneByNumero("0001/1");
        if( ! $entradaMercancias ){
            throw new \Exception("Para testear el GeneradorEsquemaContable se necesita ");
        }
        
        /* @var $generadorEsquemaContable \Pronit\ComprasBundle\Model\Contabilidad\Esquemas\EntradasMercancias\GeneradorEsquemaContable */
        $generadorEsquemaContable = $this->generadorEsquemaContable;

        /* @var $esquemaContable \Pronit\ContabilidadBundle\Model\Esquemas\EsquemaContable */        
        $esquemaContable = $generadorEsquemaContable->generar( $entradaMercancias );
        
        $this->assertEquals( 2,  $esquemaContable->getItems()->count() );        
    }
}
