<?php

namespace Pronit\CoreBundle\Model\Operaciones\Contextos\Controlling\Documentos\ImputacionSecundaria;

use Doctrine\ORM\EntityManager;
use Pronit\AutomatizacionBundle\Model\Funciones\Contexto;
use Pronit\CoreBundle\Entity\Controlling\Documentos\ItemImputacionSecundaria;

/**
 *
 * @author ldelia
 */
class ContextoItemDocumentoImputacionSecundaria extends Contexto 
{
    protected $item;

    /**
     *
     * @var EntityManager
     */
    protected $entityManager;

    public function __construct(ItemImputacionSecundaria $item, EntityManager $em) {
        parent::__construct("Compras.ItemDocumentoImputacionSecundaria");
        $this->entityManager = $em;
        $this->item = $item;
    }

    /**
     * 
     * @return ItemImputacionSecundaria
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
