<?php

namespace Pronit\CoreBundle\Tests\Model\Automatizacion\Secuencias;

use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

use Pronit\CoreBundle\Entity\Automatizacion\Secuencias\Secuencia;
use Pronit\CoreBundle\Entity\Automatizacion\Secuencias\Acceso;

/**
 *
 * @author ldelia
 */
class BuscadorRegistroCondicionTest extends KernelTestCase 
{    
    /**
     * @var \Doctrine\ORM\EntityManager
     */
    private $em;
    
    /**
     *
     * @var \Pronit\CoreBundle\Model\Automatizacion\Secuencias\BuscadorRegistroCondicion
     */
    private $buscadorRegistroCondicion;

    /**
     * {@inheritDoc}
     */
    public function setUp()
    {
        self::bootKernel();
        
        $this->buscadorRegistroCondicion = static::$kernel->getContainer()
            ->get('pronit_core.buscador_registro_condicion')
        ;
        
        $this->em = static::$kernel->getContainer()
            ->get('doctrine')
            ->getManager()
        ;        
    }

    protected function getSecuencia( $codigo )
    {
        $secuencia = $this->em
            ->getRepository('Pronit\CoreBundle\Entity\Automatizacion\Secuencias\Secuencia')
            ->findOneByCodigo($codigo)
        ;        
        return $secuencia;
    }
    
    protected function getTablaCondicion( $codigo )
    {
        $tablaCondicion = $this->em
            ->getRepository('Pronit\CoreBundle\Entity\Automatizacion\Secuencias\TablaCondicion')
            ->findOneByCodigo($codigo)
        ;        
        return $tablaCondicion;
    }

    protected function getMaterial( $codigo )
    {
        $material = $this->em
            ->getRepository('Pronit\GestionBienesYServiciosBundle\Entity\Material')
            ->findOneByCodigo($codigo)
        ;        
        return $material;
    }
    
    protected function getServicio( $codigo )
    {
        $servicio = $this->em
            ->getRepository('Pronit\GestionBienesYServiciosBundle\Entity\Servicio')
            ->findOneByCodigo($codigo)
        ;        
        return $servicio;        
    }
    
    public function testBuscarPorTablaCondicion()
    {        
        $tablaCondicion1 = $this->getTablaCondicion('T1');
        
        $materialMM001 = $this->getMaterial('MM001');
        $servicioSS002 = $this->getServicio('SS002');
        
        // Verifico que encuentre un registrocondicion según un valor existente
        $resultado = $this->buscadorRegistroCondicion->buscarPorTablaCondicion(array('material' => $materialMM001), $tablaCondicion1);        
        $this->assertNotNull($resultado);
        
        // Verifico que NO encuentre un registrocondicion según un valor inexistente
        $resultado = $this->buscadorRegistroCondicion->buscarPorTablaCondicion(array('material' => $servicioSS002), $tablaCondicion1);        
        $this->assertNull($resultado);

        $tablaCondicion2 = $this->getTablaCondicion('T2');

        // Verifico que encuentre un registrocondicion según un valor existente
        $resultado = $this->buscadorRegistroCondicion->buscarPorTablaCondicion(array('material' => $materialMM001), $tablaCondicion2);        
        $this->assertNotNull($resultado);
        
        // Verifico que NO encuentre un registrocondicion según un valor inexistente
        $resultado = $this->buscadorRegistroCondicion->buscarPorTablaCondicion(array('material' => $servicioSS002), $tablaCondicion2);        
        $this->assertNull($resultado);

        // Verifico que encuentre un registrocondicion según múltiples valores existente
        $resultado = $this->buscadorRegistroCondicion->buscarPorTablaCondicion(array('material' => $materialMM001, 'proveedor' => 'colo'), $tablaCondicion2);        
        $this->assertNotNull($resultado);
        
        // Verifico que no encuentre un registrocondicion según múltiples valores existente
        $resultado = $this->buscadorRegistroCondicion->buscarPorTablaCondicion(array('material' => $materialMM001, 'proveedor' => 'lycho'), $tablaCondicion2);        
        $this->assertNull($resultado);
        
    }

    public function testBuscarPorSecuencia()
    {        
        $secuencia = $this->getSecuencia('PR-01');
        
        $materialMM001 = $this->getMaterial('MM001');
        $servicioSS001 = $this->getServicio('SS001');
        $servicioSS002 = $this->getServicio('SS002');
        
        // Verifico que encuentre un registrocondicion según un valor existente
        $resultado = $this->buscadorRegistroCondicion->buscarPorSecuenciaAcceso(array('material' => $materialMM001), $secuencia);        
        $this->assertNotNull($resultado);
        
        // Verifico que el registroCondición encontrado esté en la tabla de condición 1 (primera en aparecer en la secuencia)
        $registroCondicion = $resultado;
        $this->assertEquals($registroCondicion->getTablaCondicion()->getCodigo() , 'T1');

        // Verifico que encuentre un registrocondicion según un valor existente
        $resultado = $this->buscadorRegistroCondicion->buscarPorSecuenciaAcceso(array('material' => $servicioSS001), $secuencia);        
        $this->assertNotNull($resultado);
        
        // Verifico que el registroCondición encontrado esté en la tabla de condición 2 (segunda en aparecer en la secuencia)
        $registroCondicion = $resultado;
        $this->assertEquals($registroCondicion->getTablaCondicion()->getCodigo() , 'T2');
        
        // Verifico que NO encuentre un registrocondicion según un valor inexistente
        $resultado = $this->buscadorRegistroCondicion->buscarPorSecuenciaAcceso(array('material' => $servicioSS002), $secuencia);        
        $this->assertNull($resultado);        
    }
    
    public function testBuscarPorSecuenciaExcepcion()
    {
        $this->setExpectedException('Exception');
        
        $secuencia = $this->getSecuencia('PR-01');        
        
        // Verifico que encuentre un registrocondicion según un valor existente
        $resultado = $this->buscadorRegistroCondicion->buscarPorSecuenciaAcceso(array('proveedor' => 'colo'), $secuencia);        
    }
    
    /**
     * {@inheritDoc}
     */
    protected function tearDown()
    {
        parent::tearDown();
        $this->em->close();
    }    
}
