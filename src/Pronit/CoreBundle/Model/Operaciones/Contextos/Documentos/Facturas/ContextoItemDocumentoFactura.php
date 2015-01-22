<?php

namespace Pronit\CoreBundle\Model\Operaciones\Contextos\Documentos\Facturas;

use Doctrine\ORM\EntityManager;
use Pronit\ComprasBundle\Entity\Documentos\Facturas\ItemFactura;
use Pronit\CoreBundle\Entity\Operaciones\Operacion;
use Pronit\CoreBundle\Model\Contabilidad\Customizing\IImputacionesCustomizingManager as FIIImputacionesCustomizingManager;
use Pronit\CoreBundle\Model\Operaciones\Contextos\Contexto;

/**
 *
 * @author ldelia
 */
class ContextoItemDocumentoFactura extends Contexto {

    protected $item;
    protected $entityManager;

    /**
     *
     * @var FIIImputacionesCustomizingManager
     */
    protected $fiImputacionesCustomizingManager;

    const CODIGO = "Compras.ItemDocumentoFactura";

    public function __construct(Operacion $operacion, ItemFactura $item, FIIImputacionesCustomizingManager $fiImputacionesCustomizingManager, EntityManager $em) {
        parent::__construct(self::CODIGO, $operacion);
        $this->entityManager = $em;
        $this->item = $item;
        $this->fiImputacionesCustomizingManager = $fiImputacionesCustomizingManager;
    }

    /**
     * 
     * @return ItemFactura
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
     * @return FIIImputacionesCustomizingManager
     */
    public function getFIImputacionesCustomizingManager() {
        return $this->fiImputacionesCustomizingManager;
    }    
}
