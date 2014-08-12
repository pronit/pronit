<?php

namespace Pronit\CoreBundle\Model\Automatizacion\EsquemasCalculo\DeterminadoresValor;

use Exception;
use OutOfRangeException;
use Pronit\CoreBundle\Model\Automatizacion\EsquemasCalculo\Contextos\ContextoItemEsquemaCalculo;

/**
 * Determina un valor a partir de los valores de los items de referencia.
 *
 * Por el momento si hay mas de un item de referencia, se devuelve la sumatoria
 * de los mismos.
 * 
 * @author gcaseres
 */
class DeterminadorValorReferencia extends DeterminadorValor {

    /**
     * 
     * @param ContextoItemEsquemaCalculo $contexto
     * @throws Exception
     * @return float
     */
    public function determinar(ContextoItemEsquemaCalculo $contexto) {
        $resultadoParcial = $contexto->getResultadoParcial();
        $referencias = $contexto->getItemEsquemaCalculo()->getReferencias();

        $valorReferencia = 0;

        foreach ($referencias as /* @var $referencia ItemEsquemaCalculo */ $referencia) {
            try {
                for ($orden = $referencia[0]; $orden <= $referencia[1]; $orden++) {
                    $valorReferencia += $resultadoParcial->getCondicion($orden)->getValor();
                }
            } catch (OutOfRangeException $e) {
                throw new Exception("No es posible determinar un valor de referencia si se hace referencia a un item que todavía no ha sido calculado.", 0, $e);
            }
        }

        return $valorReferencia;
    }

}
