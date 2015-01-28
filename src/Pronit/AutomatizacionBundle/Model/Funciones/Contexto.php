<?php

namespace Pronit\AutomatizacionBundle\Model\Funciones;

use Pronit\AutomatizacionBundle\Model\Scripting\Contexto as ContextoScript;

/**
 * Definición abstracta del contexto de una función.
 * 
 * Esta clase permite abstraer al modelo de funciones del modelo de scripting.
 *
 * @author gcaseres
 */
abstract class Contexto extends ContextoScript {

    private $codigo;
    
    protected function __construct($codigo) {
        $this->codigo = $codigo;
    }
    
    public function getCodigo() {
        return $this->codigo;
    }
}
