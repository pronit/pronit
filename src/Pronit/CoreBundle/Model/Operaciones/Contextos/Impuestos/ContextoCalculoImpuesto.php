<?php

namespace Pronit\CoreBundle\Model\Operaciones\Contextos\Impuestos;

use Pronit\AutomatizacionBundle\Model\Funciones\Contexto;

/**
 * Description of ContextoCalculoImpuesto
 *
 * @author ldelia
 */
class ContextoCalculoImpuesto extends Contexto {

    protected $montoImponible;
    protected $alicuota;

    const CODIGO = "Impuestos.CalculoImpuesto";

    public function __construct($montoImponible, $alicuota) {
        parent::__construct(self::CODIGO);

        $this->montoImponible = $montoImponible;
        $this->alicuota = $alicuota;
    }

    function getMontoImponible() {
        return $this->montoImponible;
    }

    function setMontoImponible($montoImponible) {
        $this->montoImponible = $montoImponible;
    }

    function getAlicuota() {
        return $this->alicuota;
    }

    function setAlicuota($alicuota) {
        $this->alicuota = $alicuota;
    }

}
