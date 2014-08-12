<?php

namespace Pronit\CoreBundle\Entity\Automatizacion\EsquemasCalculo;

use Pronit\CoreBundle\Model\Automatizacion\EsquemasCalculo\Contextos\ContextoEsquemaCalculo;
use Pronit\CoreBundle\Model\Automatizacion\EsquemasCalculo\Contextos\ContextoItemEsquemaCalculo;

/**
 * Description of ItemEsquemaCalculoCondicion
 *
 * @author gcaseres
 */
class ItemEsquemaCalculoCondicion extends ItemEsquemaCalculo {



    /** @var ClaseCondicion */
    protected $claseCondicion;

    public function __construct(EsquemaCalculo $esquemaCalculo, ClaseCondicion $claseCondicion) {
        parent::__construct($esquemaCalculo);
        $this->claseCondicion = $claseCondicion;
    }

    /**
     * 
     * @param ClaseCondicion $value
     */
    public function setClase(ClaseCondicion $value) {
        $this->claseCondicion = $value;
    }

    /**
     * 
     * @return ClaseCondicion
     */
    public function getClase() {
        return $this->claseCondicion;
    }

    /**
     * 
     * @param ContextoEsquemaCalculo $contexto
     * @param ResultadoCalculo $parcial
     */
    public function calcular(ContextoItemEsquemaCalculo $contexto, ResultadoCalculo $parcial) {
        $valor = $this->claseCondicion->calcular(new ContextoItemEsquemaCalculo($contexto, $this, $parcial), $parcial);
        $parcial->addCondicion($this->getDescripcion(), $valor);
    }

}
