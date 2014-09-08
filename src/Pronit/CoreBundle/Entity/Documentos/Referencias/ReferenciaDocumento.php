<?php

namespace Pronit\CoreBundle\Entity\Documentos\Referencias;

use Pronit\CoreBundle\Entity\Documentos\Documento;

/**
 * Define una referencia desde un documento a otro.
 *
 * @author gcaseres
 */
class ReferenciaDocumento {
    /** @var Documento */
    protected $origen;
    
    /** @var Documento */
    protected $destino;
    
    public function __construct(Documento $origen, Documento $destino) {
        $this->origen = $origen;
        $this->destino = $destino;
    }
    
    /**
     * 
     * @return Documento
     */
    public function getOrigen() {
        return $this->origen;
    }
    
    /**
     * 
     * @return Documento
     */
    public function getDestino() {
        return $this->destino;
        
    }
}
