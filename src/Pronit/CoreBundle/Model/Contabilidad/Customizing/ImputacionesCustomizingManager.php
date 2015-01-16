<?php

namespace Pronit\CoreBundle\Model\Contabilidad\Customizing;

use Pronit\CoreBundle\Entity\Operaciones\OperacionContable;

use Doctrine\ORM\EntityManager;

/**
 * @author ldelia
 */
class ImputacionesCustomizingManager implements IImputacionesCustomizingManager
{
    private $em;
    
    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }
    
    /**
     * 
     * @param \Pronit\CoreBundle\Entity\Operaciones\OperacionContable $operacionContable
     * @return \Pronit\CoreBundle\Entity\Contabilidad\CuentasContables\Cuenta cuenta a imputar
     */
    public function getCuenta(OperacionContable $operacionContable)
    {
        $qb = $this->em->createQueryBuilder();
        $qb->select('aoc')
            ->from('\Pronit\CoreBundle\Entity\Contabilidad\Customizing\AsignacionOperacionCuenta', 'aoc')
            ->andWhere('aoc.operacion = :operacion')
            ->setParameter('operacion', $operacionContable);
            
        $result = $qb->getQuery()->getResult();
        
        if( count($result) > 0 ){
            $asociacionOperacionCuenta = $result[0];
            return $asociacionOperacionCuenta->getCuenta();
        }else{
            return null;
        }       
    }
}
