<?php

namespace Pronit\CoreBundle\Model\Automatizacion\EsquemasCalculo\DeterminadoresValor;

use Pronit\CoreBundle\Model\Automatizacion\EsquemasCalculo\Contextos\ContextoItemEsquemaCalculo;

/**
 * Description of DeterminadorValor
 *
 * @author gcaseres
 */
abstract class DeterminadorValor {

    /**
     * 
     * @param ContextoItemEsquemaCalculo $contexto
     * @return float Valor determinado
     */
    public abstract function determinar(ContextoItemEsquemaCalculo $contexto);
}
