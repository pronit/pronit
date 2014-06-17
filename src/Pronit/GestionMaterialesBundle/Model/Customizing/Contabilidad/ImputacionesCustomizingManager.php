<?php

namespace Pronit\GestionMaterialesBundle\Model\Customizing\Contabilidad;

use Pronit\CoreBundle\Entity\Contabilidad\OperacionContable;
use Pronit\CoreBundle\Entity\Documentos\ClasificadorItem;
use Pronit\GestionMaterialesBundle\Entity\CategoriaValoracion;

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
     * @param \Pronit\CoreBundle\Entity\Documentos\ClasificadorItem $clasificador
     * @param \Pronit\CoreBundle\Entity\Contabilidad\OperacionContable $operacionContable
     * @param \Pronit\GestionMaterialesBundle\Entity\CategoriaValoracion $categoriaValoracion
     * @return \Pronit\ContabilidadBundle\Entity\CuentasContables\Cuenta cuenta a imputar
     */
    public function getCuenta(ClasificadorItem $clasificador, OperacionContable $operacionContable, CategoriaValoracion $categoriaValoracion)
    {
        $qb = $this->em->createQueryBuilder();
        $qb->select('ic')
            ->from('Pronit\GestionMaterialesBundle\Entity\Customizing\Contabilidad\ImputacionContable', 'ic')
            ->join('ic.asociacionOperacionClasificadorItem', 'aoci')
            ->where('ic.categoriaValoracion = :categoriaValoracion')
            ->andWhere('aoci.operacion = :operacion')
            ->andWhere('aoci.clasificador = :clasificador')
            ->setParameter('categoriaValoracion', $categoriaValoracion)
            ->setParameter('operacion', $operacionContable)
            ->setParameter('clasificador', $clasificador);
            
        $result = $qb->getQuery()->getResult();
      
        if( count( $result ) > 0 ){
            $imputacionContable = $result[0];
            return $imputacionContable->getCuenta();
        }else{
            return null;
        }       
    }
}
