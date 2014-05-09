<?php

namespace Pronit\CoreBundle\Tests\Entity\Operaciones;

use Pronit\CoreBundle\Model\Operaciones\Contexto;

/**
 * Description of ContextoPrueba
 *
 * @author gcaseres
 */
class ContextoPrueba extends Contexto {
    
    private $valorInicial;
    
    public function __construct() {
        parent::__construct("prueba");
    }
    
    public function setValorInicial($value) {
        $this->valorInicial = $value;
    }
    
    public function getValorInicial() {
        return $this->valorInicial;
    }
    
    
}
