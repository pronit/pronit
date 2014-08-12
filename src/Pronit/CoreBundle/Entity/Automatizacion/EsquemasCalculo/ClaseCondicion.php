<?php

namespace Pronit\CoreBundle\Entity\Automatizacion\EsquemasCalculo;

use Pronit\CoreBundle\Entity\Automatizacion\Estrategias\EstrategiaCalculo;
use Pronit\CoreBundle\Model\Automatizacion\EsquemasCalculo\Contextos\ContextoItemEsquemaCalculo;

/**
 * Description of ClaseCondicion
 *
 * @author gcaseres
 */
class ClaseCondicion {

    /** @var string */
    protected $codigo;

    /** @var string */
    protected $nombre;

    /** @var EstrategiaCalculo */
    protected $estrategiaCalculo;

    public function setCodigo($value) {
        $this->codigo = $value;
    }

    public function getCodigo() {
        return $this->codigo;
    }

    public function setNombre($value) {
        $this->nombre = $value;
    }

    public function getNombre() {
        return $this->nombre;
    }

    /**
     * 
     * @param EstrategiaCalculo $value
     */
    public function setEstrategiaCalculo(EstrategiaCalculo $value) {
        $this->estrategiaCalculo = $value;
    }

    /**
     * 
     * @return EstrategiaCalculo
     */
    public function getEstrategiaCalculo() {
        return $this->estrategiaCalculo;
    }

    /**
     * 
     * @param ContextoItemEsquemaCalculo $contexto
     */
    public function calcular(ContextoItemEsquemaCalculo $contexto, ResultadoCalculo $parcial) {
        $descripcion = $contexto->getItemEsquemaCalculo()->getDescripcion();

        $valor = $this->estrategiaCalculo->calcular($contexto);

        $parcial->addCondicion($descripcion, $valor);
    }

}
