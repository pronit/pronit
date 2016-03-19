<?php

namespace Pronit\CoreBundle\Entity\Almacenamiento;

use Pronit\ParametrizacionGeneralBundle\Entity\Escala;

/**
 *
 * @author gcaseres
 */
class CantidadPresentacionExistencia {

    /**
     *
     * @var float
     */
    private $valor;

    /**
     *
     * @var Escala
     */
    private $escala;

    public function __construct($valor, Escala $escala) {
        $this->valor = $valor;
        $this->escala = $escala;
    }

    /**
     * 
     * @param float $valor
     */
    public function setValor($valor) {
        $this->valor = $valor;
    }

    /**
     * 
     * @return float
     */
    public function getValor() {
        return $this->valor;
    }

    /**
     * 
     * @return Escala
     */
    public function getEscala() {
        return $this->escala;
    }

}
