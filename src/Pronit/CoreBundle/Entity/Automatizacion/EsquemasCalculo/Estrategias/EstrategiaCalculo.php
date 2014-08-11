<?php

namespace Pronit\CoreBundle\Entity\Automatizacion\EsquemasCalculo\Estrategias;

use Doctrine\Common\Collections\ArrayCollection;
use Exception;
use Pronit\CoreBundle\Model\Automatizacion\EsquemasCalculo\Contextos\ContextoItemEsquemaCalculo;
use Pronit\CoreBundle\Model\Automatizacion\EsquemasCalculo\DeterminadoresValor\DeterminadorValor;

/**
 * Description of EstrategiaCalculo
 *
 * @author gcaseres
 */
abstract class EstrategiaCalculo {
    
    /** @var ArrayCollection */
    protected $determinadoresOperandos;
    
    public function __construct() {
        $this->determinadoresOperandos = new ArrayCollection();
    }
    
    public function addDeterminador(DeterminadorValor $determinador) {
        if (count($this->determinadoresOperandos) == $this->getOperandosRequeridos()) {
            throw new Exception("La estrategia actual no admite mas de " . $this->getOperandosRequeridos() . " operandos");
        }
        $this->determinadoresOperandos->add($determinador);
    }
    
    public function removeDeterminador(int $index) {
        $this->determinadoresOperandos->remove($index);
    }
    
    /**
     * Obtiene la cantidad de operandos que son requeridos para ejecutar la
     * estrategia de cáculo correctamente.
     * 
     * @return int Cantidad de operandos requeridos por la estrategia.
     */
    public abstract function getOperandosRequeridos();
    
    /**
     * 
     * @param ContextoItemEsquemaCalculo $contexto
     * @return float
     */
    public abstract function calcular(ContextoItemEsquemaCalculo $contexto);
}
