<?php

namespace Pronit\CoreBundle\Model\Operaciones\Contextos\Documentos;

use Doctrine\ORM\EntityManager;
use Pronit\AutomatizacionBundle\Model\Funciones\Contexto;
use Pronit\ComprasBundle\Entity\Documentos\EntradasMercancias\ItemEntradaMercancias;

/**
 *
 * @author ldelia
 */
class ContextoItemDocumentoEntradaMercancias extends Contexto {

    protected $item;

    /**
     *
     * @var EntityManager
     */
    protected $entityManager;

    public function __construct(ItemEntradaMercancias $item, EntityManager $em) {
        parent::__construct("Compras.ItemDocumentoEntradaMercancias");
        $this->entityManager = $em;
        $this->item = $item;
    }

    /**
     * 
     * @return ItemEntradaMercancias
     */
    public function getItem() {
        return $this->item;
    }

    /**
     * 
     * @return EntityManager
     */
    public function getEntityManager() {
        return $this->entityManager;
    }
    
}
