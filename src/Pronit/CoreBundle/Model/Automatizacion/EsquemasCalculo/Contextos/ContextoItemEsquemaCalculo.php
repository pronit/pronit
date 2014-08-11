<?php
namespace Pronit\CoreBundle\Model\Automatizacion\EsquemasCalculo\Contextos;

use Pronit\CoreBundle\Entity\Automatizacion\EsquemasCalculo\ItemEsquemaCalculo;
use Pronit\CoreBundle\Entity\Automatizacion\EsquemasCalculo\ResultadoCalculo;

/**
 * Description of ContextoItemEsquemaCalculo
 *
 * @author gcaseres
 */
class ContextoItemEsquemaCalculo {
    /** @var ContextoEsquemaCalculo */
    protected $contextoEsquemaCalculo;
    
    /** @var ItemEsquemaCalculo */
    protected $itemEsquemaCalculo;
    
    protected $resultadoParcial;
    
    public function __construct(ContextoEsquemaCalculo $contextoEsquemaCalculo, ItemEsquemaCalculo $itemEsquemaCalculo, ResultadoCalculo $resultadoParcial) {
        $this->itemEsquemaCalculo = $itemEsquemaCalculo;
        $this->contextoEsquemaCalculo = $contextoEsquemaCalculo;
        $this->resultadoParcial = $resultadoParcial;
    }
    
    /**
     * 
     * @return ItemEsquemaCalculo
     */
    public function getItemEsquemaCalculo() {
        return $this->itemEsquemaCalculo;
    }
    
    /**
     * 
     * @return ResultadoCalculo
     */
    public function getResultadoParcial() {
        return $this->resultadoParcial;
    }
}
