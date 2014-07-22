<?php

namespace Pronit\Geographic\CoreBundle\Model\MetadataEntityRepository;

use Doctrine\ORM\EntityManager;

/**
 * Description of EntityTableMetadataQueryBuilder
 *
 * @author ldelia
 */
class MetadataEntityRepository
{
    public function find(EntityManager $em, $params)
    {        
        $qb2 = $em->createQueryBuilder()
                    ->select( 'sda.id' )
                    ->from('Pronit\Geographic\CoreBundle\Entity\DivisionAdministrativaMetadataValue','damv')
                    ->join('damv.divisionAdministrativa','sda');

        $i=1;
        foreach( $params as $metadataName => $metadataValue ){
            $qb2->orWhere("( damv.metadataName='{$metadataName}' AND damv.value = ?{$i} )");
            $i++;
        }
        $subDQL = $qb2
                    ->groupBy('damv.divisionAdministrativa')
                    ->having('count(damv.id) = ' . count( $params ))                    
                    ->getDQL();
        
        
        $qb = $em->createQueryBuilder();
        
        $qb->select('da')
            ->from('Pronit\Geographic\CoreBundle\Entity\DivisionAdministrativa','da')
            ->where(
                $qb->expr()->in(  'da.id', $subDQL )
            );
        
        $i=1;
        foreach( $params as $metadataName => $metadataValue ){
            $qb->setParameter($i, $metadataValue);
            $i++;
        }
        
        return $qb->getQuery()->getResult();
    }
}
