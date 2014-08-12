<?php

namespace Pronit\CoreBundle\Entity\Automatizacion\EsquemasCalculo;

use Doctrine\Common\Collections\ArrayCollection;
use Iterator;
use OutOfRangeException;


/**
 * Description of ResultadoCalculo
 *
 * @author gcaseres
 */
class ResultadoCalculo {
    protected $condiciones;
    
    public function __construct() {
        $this->condiciones = new ArrayCollection();
    }
    
    public function getCondicionesCount() {
        return $this->condiciones->count();
    }
    
    /**
     * 
     * @param string $descripcion
     * @param float $valor
     */
    public function addCondicion($descripcion, $valor) {
        $orden = $this->getCondicionesCount();
        $this->condiciones->add(new Condicion($orden, $descripcion, $valor));
    }
    
    /**
     * 
     * @param int $orden
     */
    public function removeCondicion($orden) {
        $this->condiciones->remove($orden);        
    }
    
    /**
     * 
     * @param int $orden
     * @throws OutOfRangeException
     * @return Condicion
     */
    public function getCondicion($orden) {
        if (!$this->condiciones->containsKey($orden)) {
            throw new OutOfRangeException("El orden de condición especificado no existe.");
        }
        return $this->condiciones->get($orden);
    }
    
    public function hasCondicion($orden) {
        return $this->condiciones->containsKey($orden);
    }
    
    /**
     * 
     * @return Iterator
     */
    public function getCondiciones() {
        return $this->condiciones->getIterator();
    }
}
