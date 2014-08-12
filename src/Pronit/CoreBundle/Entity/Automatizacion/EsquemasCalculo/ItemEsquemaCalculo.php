<?php

namespace Pronit\CoreBundle\Entity\Automatizacion\EsquemasCalculo;

use ArrayObject;
use InvalidArgumentException;
use Iterator;
use OutOfBoundsException;
use Pronit\CoreBundle\Model\Automatizacion\EsquemasCalculo\Contextos\ContextoEsquemaCalculo;
use Pronit\CoreBundle\Model\Automatizacion\EsquemasCalculo\Contextos\ContextoItemEsquemaCalculo;

/**
 * Description of ItemEsquemaCalculo
 *
 * @author gcaseres
 */
abstract class ItemEsquemaCalculo {

    protected $orden;
    protected $descripcion;
    protected $referencias;
    protected $owner;

    public function __construct() {
        $this->referencias = array();
    }

    /**
     * Asigna el esquema propietario de este item.
     * 
     * Este método no debería utilizarse directamente, sino que es el esquema
     * el que lo maneja.
     * 
     * @param EsquemaCalculo $owner Esquema de cálculo propietario, o NULL si
     * se desea eliminar del esquema.
     */
    public function setOwner(EsquemaCalculo $owner = null) {
        $this->owner = $owner;
    }

    /**
     * Obtiene el esquema de cálculo propietario de este item.
     * 
     * @return EsquemaCalculo
     */
    public function getOwner() {
        return $this->owner;
    }

    /**
     * Establece el orden del item dentro del esquema de cálculo propietario.
     * 
     * Este método no debería utilizarse directamente, sino que es el esquema
     * el que lo maneja.     
     * 
     * @param int $orden
     */
    public function setOrden($orden) {
        $this->orden = $orden;
    }

    /**
     * Obtiene el orden del item dentro del esquema de cálculo propietario.
     * 
     * @return int
     */
    public function getOrden() {
        return $this->orden;
    }

    public function setDescripcion($value) {
        $this->descripcion = $value;
    }

    public function getDescripcion() {
        return $this->descripcion;
    }

    /**
     * Establece una referencia a un rango de posiciones del esquema de cálculo.
     * 
     * Notar que la referencia se hace a la posición y no al item en particular.
     * Esto implica que si el item cambia, la referencia no cambia.
     * 
     * @param int $orden
     * @return int Índice de la referencia agregada.
     */
    public function addReferencia($desdeOrden, $hastaOrden) {
        if ($desdeOrden > $hastaOrden) {
            throw new InvalidArgumentException("El rango especificado es inválido.");
        }
        
        array_push($this->referencias, array($desdeOrden, $hastaOrden));
    }

    /**
     * Elimina una referencia a una posición del esquema de cálculo
     * 
     * @param int $index Indice identificador de la referencia.
     */
    public function removeReferencia($index) {
        $i = 0;
        $referenciaKey = null;
        
        /*
         * Se busca la referencia número $index en el arreglo de referencias y
         * se obtiene su clave dentro del arreglo.
         */
        foreach ($this->referencias as $key => $value) {            
            if ($i == $index) {
                $referenciaKey = $key;
                break;
            }
            $i++;
        }

        if ($referenciaKey === null) {
            throw new OutOfBoundsException("El índice especificado no corresponde a una referencia.");
        }

        unset($this->referencias[$referenciaKey]);

    }

    /**
     * 
     * @return Iterator
     */
    public function getReferencias() {
        $array = new ArrayObject($this->referencias);
        return $array->getIterator();
    }

    public function getReferenciasCount() {
        return count($this->referencias);
    }

    /**
     * 
     * @param ContextoEsquemaCalculo $contexto
     * @param ResultadoCalculo $parcial
     * @return Condicion
     */
    public abstract function calcular(ContextoItemEsquemaCalculo $contexto, ResultadoCalculo $parcial);
}
