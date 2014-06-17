<?php

namespace Pronit\CoreBundle\Model\Operaciones\Contextos\Documentos;

use Pronit\CoreBundle\Model\Operaciones\Contextos\Contexto;
use Pronit\ComprasBundle\Entity\EntradasMercancias\EntradaMercancias;

/**
 *
 * @author ldelia
 */
class ContextoDocumentoEntradaMercancias extends Contexto {
    
    protected $documento;
    
    public function __construct(EntradaMercancias $documento) {
        parent::__construct("Compras.DocumentoEntradaMercancias");
        
        $this->documento = $documento;        
    }
    
    /**
     * 
     * @return \Pronit\ComprasBundle\Entity\EntradasMercancias\EntradaMercancias
     */
    public function getDocumento(){
        return $this->documento;
    }
}
