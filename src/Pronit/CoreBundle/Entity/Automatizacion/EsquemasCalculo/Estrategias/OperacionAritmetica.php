<?php

namespace Pronit\CoreBundle\Entity\Automatizacion\EsquemasCalculo\Estrategias;

use InvalidArgumentException;
use Pronit\CoreBundle\Entity\Automatizacion\Estrategias\EstrategiaCalculo;
use Pronit\CoreBundle\Model\Automatizacion\EsquemasCalculo\Contextos\ContextoItemEsquemaCalculo;
use Pronit\CoreBundle\Model\Automatizacion\EsquemasCalculo\DeterminadoresValor\DeterminadorValor;
use Pronit\CoreBundle\Model\Automatizacion\EsquemasCalculo\Estrategias\OperacionAritmetica\Operacion;
use Pronit\CoreBundle\Model\Automatizacion\EsquemasCalculo\Estrategias\OperacionAritmetica\Suma;

/**
 * Description of OperacionAritmetica
 *
 * @author gcaseres
 */
class OperacionAritmetica extends EstrategiaCalculo {

    /** @var string */
    protected $operacionClassId;

    /** @var Operacion */
    protected $operacion;
    
    public function __construct(Operacion $operacion = null) {
        if ($operacion === null) {
            $operacion = new Suma();
        }
        $this->setOperacion($operacion);        
    }

    public function setOperacion(Operacion $value) {
        $this->operacion = $value;
        $this->operacionClassId = $this->operacion->getClassId();
    }

    private function crearOperacionFromClassId($classId) {
        switch ($classId) {
            case Suma::CLASS_ID:
                return new Suma();
            default:
                throw new InvalidArgumentException("El ClassId especificado no es válido.");
        }
    }

    public function getOperacion() {
        if ($this->operacion == null) {
            if ($this->operacionClassId != null) {
                $this->operacion = $this->crearOperacionFromClassId($this->operacionClassId);
            }
        }
        return $this->operacion;
    }        

    public function calcular(ContextoItemEsquemaCalculo $contexto) {
        $valores = array();
        for ($i = 0; $i < $this->determinadoresOperandos->count(); $i++) {

            /* @var $determinador DeterminadorValor */
            $determinador = $this->determinadoresOperandos->get($i);

            $valores[$i] = $determinador->determinar($contexto);
        }

        return $this->operacion->calcular($valores);
    }
    
    public function getOperandosRequeridos() {
        return $this->operacion->getOperandosRequeridos();
    }

}
