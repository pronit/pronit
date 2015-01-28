<?php

namespace Pronit\CustomizingBundle\Model\Operaciones;

use Doctrine\ORM\EntityManager;
use Pronit\CoreBundle\Entity\Documentos\ClaseDocumento;
use Pronit\CoreBundle\Entity\Documentos\ClasificadorItem;
use Pronit\ParametrizacionGeneralBundle\Entity\ItemCondicionPagos;

/**
 *
 * @author ldelia
 */
class OperacionesCustomizingManager implements IOperacionesCustomizingManager {

    private $em;

    public function __construct(EntityManager $em) {
        $this->em = $em;
    }

    public function getMappingsByClasificadorItem(ClasificadorItem $clasificador) {
        $qb = $this->em->createQueryBuilder();
        $qb->select('e')
                ->from('Pronit\CustomizingBundle\Entity\Operaciones\MappingClasificadorItemOperacion', 'e')
                ->where('e.clasificador = :clasificador')
                ->setParameter('clasificador', $clasificador);


        $result = $qb->getQuery()->getResult();
        return $result;
    }
    
    public function getMappingsCondicionPagosByClaseDocumento(ClaseDocumento $claseDocumento) {
        $qb = $this->em->createQueryBuilder();
        $qb->select('e')
                ->from('Pronit\CustomizingBundle\Entity\Operaciones\MappingClaseDocumentoOperacion', 'e')
                ->where('e.claseDocumento = :claseDocumento')
                ->setParameter('claseDocumento', $claseDocumento);

        $result = $qb->getQuery()->getResult();
        return $result[0];        
    }

}
