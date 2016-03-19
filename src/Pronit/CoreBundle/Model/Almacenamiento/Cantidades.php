<?php

namespace Pronit\CoreBundle\Model\Almacenamiento;

use Pronit\ParametrizacionGeneralBundle\Entity\Escala;
use Pronit\ParametrizacionGeneralBundle\Entity\SistemaMedicion;
use SplObjectStorage;

/**
 *
 * @author gcaseres
 */
class Cantidades {

    /**
     *
     * @var SplObjectStorage
     */
    private $cantidades;

    public function __construct() {
        $this->cantidades = new SplObjectStorage();
    }

    /**
     * 
     * @param float $valor
     * @param Escala $escala
     */
    public function set($valor, Escala $escala) {
        $this->cantidades->offsetSet($escala->getSistemaMedicion(), new Cantidad($valor, $escala));
    }

    /**
     * 
     * @param SistemaMedicion $sistemaMedicion
     * @return Cantidad
     */
    public function get(SistemaMedicion $sistemaMedicion) {
        return $this->cantidades->offsetGet($sistemaMedicion);
    }

    /**
     * 
     * @param SistemaMedicion $sistemaMedicion
     * @return boolean
     */
    public function has(SistemaMedicion $sistemaMedicion) {
        return $this->cantidades->offsetExists($sistemaMedicion);
    }

    /**
     * 
     * @return int
     */
    public function count() {
        return $this->cantidades->count();
    }

    public function __toString() {
        return join(',', (array)$this->cantidades);
    }

}
