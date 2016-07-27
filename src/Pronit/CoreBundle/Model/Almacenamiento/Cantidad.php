<?php

namespace Pronit\CoreBundle\Model\Almacenamiento;

use Pronit\ParametrizacionGeneralBundle\Entity\Escala;

/**
 *
 * @author gcaseres
 */
class Cantidad {

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

    /**
     * 
     * @param float $valor
     */
    public function __construct($valor, Escala $escala) {
        $this->valor = $valor;
        $this->escala = $escala;
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
    
    public function __toString() {
        return sprintf("%s %s (%s)", $this->valor, $this->escala->getAbreviatura(), $this->escala->getSistemaMedicion()->getAbreviatura());
    }

    /**
     * 
     * @return Cantidad
     */
    public function escalar(Escala $escala) {
        return new Cantidad($this->escala->escalar($this->valor, $escala), $escala);
    }
}
