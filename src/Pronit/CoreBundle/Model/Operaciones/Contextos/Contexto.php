<?php

namespace Pronit\CoreBundle\Model\Operaciones\Contextos;

use Pronit\CoreBundle\Entity\Operaciones\Operacion;

/**
 *
 * @author gcaseres
 */
abstract class Contexto {
    
    /**
     *
     * @var Operacion
     */
    protected $operacion;
    
    protected $codigo;
    
    protected function __construct($codigo, Operacion $operacion) {
        $this->codigo = $codigo;
        $this->operacion = $operacion;
    }
    
    public function getCodigo() {
        return $this->codigo;
    }
    
    /**
     * 
     * @return Operacion
     */
    public function getOperacion() {
       return $this->operacion; 
    }
}
