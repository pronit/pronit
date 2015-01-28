<?php

namespace Pronit\AutomatizacionBundle\Model\Funciones;

use Exception;
use PHPSandbox\PHPSandbox;
use Pronit\AutomatizacionBundle\Entity\Funcion;
use Pronit\AutomatizacionBundle\Model\Funciones\Contexto;

/**
 * Clase encargada de ejecutar una funcion de Scripting.
 * 
 * Para evitar que un script declare mas de una vez las mismas clases/funciones
 * se utiliza un registro que almacena aquellos scripts que ya han sido 
 * ejecutados.
 * 
 * Esta clase utiliza el patrón Singleton para asegurar que el registro de
 * scripts ejecutados sea único.
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
        $sandbox = PHPSandbox::create();
        $sandbox->allow_functions = true;
        $sandbox->allow_classes = true;
        $sandbox->allow_namespaces = false;
        $sandbox->allow_casting = true;
        $sandbox->auto_whitelist_interfaces = true;
        $sandbox->define_alias('Pronit\AutomatizacionBundle\Model\Scripting', 'Scripting');
        $sandbox->define_alias('Pronit\CoreBundle\Model\Automatizacion\Scripting', 'Core_Scripting');
        $sandbox->define_alias('Pronit\CoreBundle\Model\Operaciones\Contextos', 'Core_Operaciones_Contextos');
        $sandbox->whitelist_type('Exception');
        $sandbox->whitelist_class('Scripting\Script');
        $sandbox->whitelist_class('Scripting\Contexto');
        $sandbox->whitelist_type('Core_Scripting\ItemFinanzasDTO');
        $sandbox->whitelist_type('Core_Operaciones_Contextos\Impuestos\ContextoCalculoImpuesto');
        $sandbox->whitelist_func('get_class');
        $sandbox->convert_errors = true;

        $sandbox->set_exception_handler(function($exception) {
            throw new Exception($exception->getMessage());
        });
        return $sandbox;
    }

    public function ejecutar(Funcion $funcion, Contexto $contexto) {

        $sandbox = $this->createSandbox();        
        $namespace = $funcion->getNombre();
        $nombreClase = $namespace . '\\' . $funcion->getNombreClase();
        $sandbox->define_namespace($funcion->getNombre());

        if (!isset($this->registroFunciones[$funcion->getNombre()])) {            
            try {
                $sandbox->execute($funcion->getScript());
                $this->registroFunciones[$funcion->getNombre()] = true;
            } catch (Exception $e) {
                throw new Exception("No se pudo generar la clase del script correctamente: (" . $e->getMessage() . ")");
            }
        }
        
        /**
         * TODO: El código se está definiendo en el Sandbox pero se ejecuta por
         * fuera del mismo.
         * Deberiá ejecutarse dentro del sandbox para controlar correctamente
         * las excepciones producidas.
         */
        
        try {            
            $script = new $nombreClase();
            return $script->ejecutar($contexto);            
        } catch (Exception $e) {
            throw new Exception("Error en script '" . $funcion->getNombre() . "': " . $e->getMessage());
        }
    }

}
