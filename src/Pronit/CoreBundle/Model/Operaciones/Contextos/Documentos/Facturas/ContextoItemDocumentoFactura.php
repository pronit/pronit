<?php

namespace Pronit\CoreBundle\Model\Operaciones\Contextos\Documentos\Facturas;

use Doctrine\ORM\EntityManager;
use Pronit\ComprasBundle\Entity\Documentos\Facturas\ItemFactura;
use Pronit\CoreBundle\Model\Operaciones\Contextos\Contexto;

/**
 *
 * @author ldelia
 */
class ContextoItemDocumentoFactura extends Contexto {
    
    protected $item;
    protected $entityManager;
    
    const CODIGO = "Compras.ItemDocumentoFactura";
    
    public function __construct(ItemFactura $item, EntityManager $em) 
    {
        parent::__construct( self::CODIGO );
        $this->entityManager = $em;
        $this->item = $item;        
    }
    
    /**
     * 
     * @return ItemFactura
     */
    public function getItem()
    {
        return $this->item;
    }
    
    /**
     * 
     * @return EntityManager
     */
    public function getEntityManager() 
    {
        return $this->entityManager;
    }
}
