<?php

namespace Pronit\CoreBundle\Entity\Automatizacion\EsquemasCalculo;

use Pronit\CoreBundle\Model\Automatizacion\EsquemasCalculo\Contextos\ContextoItemEsquemaCalculo;

/**
 * Description of ItemEsquemaCalculoTotalizador
 *
 * @author gcaseres
 */
class ItemEsquemaCalculoTotalizador extends ItemEsquemaCalculo {

    public function __construct() {
        parent::__construct();
    }
    
    public function calcular(ContextoItemEsquemaCalculo $contexto, ResultadoCalculo $parcial) {
        $result = 0;
        
        foreach ($parcial->getCondiciones() as /* @var $condicion Condicion */ $condicion) {            
            /*
             * TODO: Filtrar las condiciones que sean de fines estadísticos. 
             */
            $result += $condicion->getValor();
        }
        
        $parcial->addCondicion($this->getDescripcion(), $result);
    }

}
