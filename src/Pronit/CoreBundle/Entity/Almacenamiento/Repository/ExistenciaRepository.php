<?php
namespace Pronit\CoreBundle\Entity\Almacenamiento\Repository;


use Doctrine\ORM\EntityRepository;
use Pronit\CoreBundle\Entity\Almacenamiento\Existencia;
use Pronit\EstructuraEmpresaBundle\Entity\Almacen;
use Pronit\GestionBienesYServiciosBundle\Entity\Material;

class ExistenciaRepository extends EntityRepository implements IExistenciaRepository
{
    function add(Existencia $existencia)
    {
        $this->getEntityManager()->persist($existencia);
        $this->getEntityManager()->flush();
    }

    function findOneByAlmacenYMaterial(Almacen $almacen, Material $material)
    {
        $qb = $this->createQueryBuilder('e');
        $qb->andWhere('e.almacen = :almacen')
            ->andWhere('e.material = :material')
            ->setParameter('almacen', $almacen)
            ->setParameter('material', $material);
        
        return $qb->getQuery()->getSingleResult();
    }
}