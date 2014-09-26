<?php

namespace Pronit\CoreBundle\Model\Operaciones\Contextos\Documentos;

use Pronit\ComprasBundle\Entity\Documentos\EntradasMercancias\ItemEntradaMercancias;
use Pronit\CoreBundle\Model\Operaciones\Contextos\Contexto;

/**
 *
 * @author ldelia
 */
class ContextoItemDocumentoEntradaMercancias extends Contexto {
    
    protected $item;
    
    public function __construct(ItemEntradaMercancias $item) {
        parent::__construct("Compras.ItemDocumentoEntradaMercancias");
        
        $this->item = $item;        
    }
    
    /**
     * 
     * @return \Pronit\ComprasBundle\Entity\Documentos\EntradasMercancias\ItemEntradaMercancias
     */
    public function getItem(){
        return $this->item;
    }
}
