<?php

namespace Pronit\CoreBundle\Model\Automatizacion\Scripting;

/**
 * Description of Contexto
 *
 * @author gcaseres
 */
class Contexto extends \Pronit\AutomatizacionBundle\Model\Scripting\Contexto {
    
    protected $contextoOperacion;
    
    public function __construct(\Pronit\CoreBundle\Model\Operaciones\Contexto $contextoOperacion) {
        $this->contextoOperacion = $contextoOperacion;
    }
    
    public function getContextoOperacion() {
        return $this->contextoOperacion;
    }
}
