<?php

namespace Pronit\CoreBundle\Model\Operaciones\Contextos;

/**
 *
 * @author gcaseres
 */
abstract class Contexto {
    
    protected $codigo;
    
    protected function __construct($codigo) {
        $this->codigo = $codigo;
    }
    
    public function getCodigo() {
        return $this->codigo;
    }
}