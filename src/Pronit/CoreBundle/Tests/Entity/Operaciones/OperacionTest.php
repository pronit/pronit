<?php

namespace Pronit\CoreBundle\Tests\Entity\Operaciones;

use Pronit\AutomatizacionBundle\Entity\Funcion;

/**
 *
 * @author gcaseres
 */
class OperacionesTest extends \PHPUnit_Framework_TestCase {
    
    public function createOperacion() {
        $operacion = new OperacionPrueba();
        $operacion->setContextosAceptados(array("prueba"));
        $operacion->setCodigo("OP_PRUEBA");
        $operacion->setNombre("Operacion de prueba");
        
        $funcion = new Funcion();
        $funcion->setNombre("prueba");
        $funcion->setNombreClase("ScriptPrueba");
        $funcion->setScript('
            class ScriptPrueba extends Scripting\Script {
                public function ejecutar(Scripting\Contexto $contexto) {
                    $contextoOperacion = $contexto->getContextoOperacion();
                    
                    return $contextoOperacion->getValorInicial() + 50;
                }
            }
        ');
        
        $operacion->setFuncion($funcion);
        
        return $operacion;
    }
    
    public function testEjecutar() {
        $op = $this->createOperacion();
        $op->setContextosAceptados(array("prueba"));
        
        $contexto = new ContextoPrueba();
        $contexto->setValorInicial(200);
        
        $result = $op->ejecutar($contexto);
        
        $this->assertTrue($result == 250);
    }
    
    public function testEjecutarContextoIncorrecto() {
        $op = $this->createOperacion();
        $op->setContextosAceptados(array('contexto_diferente'));
        
        $contexto = new ContextoPrueba();
        $contexto->setValorInicial(200);
        
        $this->setExpectedException('Exception');
        $op->ejecutar($contexto);
        
               
    }
    
}
