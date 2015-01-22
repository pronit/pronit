<?php

namespace Pronit\CoreBundle\Model\Operaciones\Contextos\Documentos;

use Doctrine\ORM\EntityManager;
use Pronit\ComprasBundle\Entity\Documentos\EntradasMercancias\ItemEntradaMercancias;
use Pronit\CoreBundle\Entity\Operaciones\Operacion;
use Pronit\CoreBundle\Model\Contabilidad\Customizing\IImputacionesCustomizingManager as FIIImputacionesCustomizingManager;
use Pronit\CoreBundle\Model\Operaciones\Contextos\Contexto;
use Pronit\GestionBienesYServiciosBundle\Model\Customizing\Contabilidad\IImputacionesCustomizingManager as MMIImputacionesCustomizingManager;

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

    /**
     *
     * @var MMIImputacionesCustomizingManager
     */
    protected $mmImputacionesCustomizingManager;

    /**
     *
     * @var FIIImputacionesCustomizingManager
     */
    protected $fiImputacionesCustomizingManager;

    public function __construct(Operacion $operacion, ItemEntradaMercancias $item, MMIImputacionesCustomizingManager $mmImputacionesCustomizingManager, FIIImputacionesCustomizingManager $fiImputacionesCustomizingManager, EntityManager $em) {
        parent::__construct("Compras.ItemDocumentoEntradaMercancias", $operacion);
        $this->entityManager = $em;
        $this->item = $item;
        $this->mmImputacionesCustomizingManager = $mmImputacionesCustomizingManager;
        $this->fiImputacionesCustomizingManager = $fiImputacionesCustomizingManager;
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

    /**
     * 
     * @return MMIImputacionesCustomizingManager
     */
    public function getMMImputacionesCustomizingManager() {
        return $this->mmImputacionesCustomizingManager;
    }

    /**
     * 
     * @return FIIImputacionesCustomizingManager
     */
    public function getFIImputacionesCustomizingManager() {
        return $this->fiImputacionesCustomizingManager;
    }

}
