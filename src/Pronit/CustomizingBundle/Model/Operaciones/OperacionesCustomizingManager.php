<?php

namespace Pronit\CustomizingBundle\Model\Operaciones;

use Pronit\CoreBundle\Entity\Documentos\ClasificadorItem;

use Doctrine\ORM\EntityManager;

/**
 *
 * @author ldelia
 */
class OperacionesCustomizingManager implements IOperacionesCustomizingManager
{
    private $em;
    
    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }
    
    public function getOperacionesContablesByClasificadorItem( ClasificadorItem $clasificador )
    {
        $qb2 = $this->em->createQueryBuilder();
        
        $qb = $this->em->createQueryBuilder();
        $qb->select('oc')
            ->from('Pronit\CoreBundle\Entity\Operaciones\OperacionContable', 'oc')
            ->where(
                $qb->expr()->in(
                   'oc.id',
                   $qb2->select('o2.id')
                       ->from('Pronit\CustomizingBundle\Entity\Operaciones\AsociacionOperacionClasificadorItem', 'aoc')
                       ->join('aoc.operacion', 'o2')
                        ->where('aoc.clasificador = :clasificador')                       
                       ->getDQL()
                )                    
            )
            ->setParameter('clasificador', $clasificador);
            
        $result = $qb->getQuery()->getResult();
        return $result;
    }
}
