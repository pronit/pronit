<?php
namespace Pronit\AutomatizacionBundle\Model\Funciones;

use Pronit\AutomatizacionBundle\Entity\Funcion;
use Pronit\AutomatizacionBundle\Model\Funciones\Contexto;

/**
 * Description of EvaluadorFuncion
 *
 * @author gcaseres
 */
class EvaluadorFuncion {

    private static $instance;
    
    protected $registroFunciones;
    
    public static function getInstance() {
        if (EvaluadorFuncion::$instance == null) {
            EvaluadorFuncion::$instance = new EvaluadorFuncion();
        }
        
        return EvaluadorFuncion::$instance;
    }

    private function __construct() {
        $this->registroFunciones = array();
    }        
    
    protected function createSandbox() {
        $sandbox = \PHPSandbox\PHPSandbox::create();
        $sandbox->allow_functions = true;
        $sandbox->allow_classes = true;
        $sandbox->allow_namespaces = false;
        $sandbox->auto_whitelist_interfaces = true;
        $sandbox->define_alias('Pronit\AutomatizacionBundle\Model\Scripting', 'Scripting');
        $sandbox->whitelist_class('Scripting\Script');
        $sandbox->whitelist_class('Scripting\Contexto');                
        
        return $sandbox;
    }

    public function ejecutar(Funcion $funcion, Contexto $contexto) {        
        
        $sandbox = $this->createSandbox();        
        $sandbox->define_namespace($funcion->getNombre());
        $sandbox->append('return new ' . $funcion->getNombreClase() . '();');
        
        if (isset($this->registroFunciones[$funcion->getNombre()])) {
            $nombreClase = $funcion->getNombreClase();
            $script = new $nombreClase();
        } else {
            $this->registroFunciones[$funcion->getNombre()] = true;            
            $script = $sandbox->execute($funcion->getScript());
        }
        
        return $script->ejecutar($contexto);
    }

}
