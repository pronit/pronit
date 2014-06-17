<?php

namespace Pronit\AutomatizacionBundle\Tests\Model\Funciones;

use Pronit\AutomatizacionBundle\Entity\Funcion;
use Pronit\AutomatizacionBundle\Model\Scripting\Contexto;
use Pronit\AutomatizacionBundle\Model\Funciones\EvaluadorFuncion;



class EvaluadorFuncionTest extends \PHPUnit_Framework_TestCase
{
    public static function createEvaluadorFuncion() {
        return EvaluadorFuncion::getInstance();
    }
    
    public static function createFuncionValida($nombre = null, $nombreClase = null, $script = null) {
        if ($script == null) {
            if ($nombreClase == null) {
                $nombreClase = "ScriptPrueba";
            }
            
            $script = '
                class Buscador {
                    public function buscar() {
                        return 10;
                    }
                }
                
                class ' . $nombreClase . ' extends Scripting\Script {
                    public function ejecutar(Scripting\Contexto $contexto) {
                        $buscador = new Buscador();
                        return $buscador->buscar();
                    }
                }
            ';
        }
        
        if ($nombre == null) {
            $nombre = "prueba";
        }
        
        $funcion = new Funcion();
        $funcion->setNombre($nombre);
        $funcion->setNombreClase($nombreClase);
        $funcion->setScript($script);
        
        return $funcion;
    }
    
    public function testEjecutar()  {               
        $evaluador = EvaluadorFuncionTest::createEvaluadorFuncion();
        $contexto = new Contexto();
        
        $result = $evaluador->ejecutar(EvaluadorFuncionTest::createFuncionValida("script_1"), $contexto);
        
        $this->assertTrue($result == 10);
    }
    
    public function testEjecutarVariasFunciones() {
        $evaluador = EvaluadorFuncionTest::createEvaluadorFuncion();
        $contexto = new Contexto();
        
        $result = $evaluador->ejecutar(EvaluadorFuncionTest::createFuncionValida("script_1"), $contexto);

        $this->assertTrue($result == 10);

        $result = $evaluador->ejecutar(EvaluadorFuncionTest::createFuncionValida("script_2"), $contexto);

        $this->assertTrue($result == 10);        

        $result = $evaluador->ejecutar(EvaluadorFuncionTest::createFuncionValida("script_1"), $contexto);

        $this->assertTrue($result == 10);
        
    }
}
