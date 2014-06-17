<?php

namespace Pronit\CoreBundle\Model\Operaciones\Contextos\Documentos;

use Pronit\CoreBundle\Model\Operaciones\Contextos\Contexto;
use Pronit\ComprasBundle\Entity\EntradasMercancias\ItemEntradaMercancias;

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
     * @return \Pronit\ComprasBundle\Entity\EntradasMercancias\ItemEntradaMercancias
     */
    public function getItem(){
        return $this->item;
    }
}
