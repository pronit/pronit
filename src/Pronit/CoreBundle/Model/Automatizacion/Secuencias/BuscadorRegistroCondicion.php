<?php

namespace Pronit\CoreBundle\Model\Automatizacion\Secuencias;

use Doctrine\ORM\EntityManager;

use Bluegrass\Metadata\Bundle\MetadataBundle\Model\MetadataProvider\IMetadataProvider;
use Bluegrass\Metadata\Bundle\MetadataBundle\Model\MetadataProvider\Factory\IMetadataProviderFactory;

use Pronit\CoreBundle\Entity\Automatizacion\Secuencias\TablaCondicion;
use Pronit\CoreBundle\Entity\Automatizacion\Secuencias\Secuencia;
use Pronit\CoreBundle\Model\Automatizacion\Secuencias\IBuscadorRegistroCondicion;

/**
 * Description of BuscadorRegistroCondicion
 *
 * @author ldelia
 */
class BuscadorRegistroCondicion implements IBuscadorRegistroCondicion
{
    protected $em;
    
    protected $metadataProviderFactory;
    
    public function __construct(EntityManager $em, IMetadataProviderFactory $metadataProviderFactory)
    {
        $this->em = $em;
        $this->metadataProviderFactory = $metadataProviderFactory;
    }

    /**
     * 
     * @param type $keyValues
     * @param \Pronit\CoreBundle\Entity\Automatizacion\Secuencias\Secuencia $secuencia
     * @return \Pronit\CoreBundle\Entity\Automatizacion\Secuencias\RegistroCondicion | null
     */
    public function buscarPorSecuenciaAcceso($keyValues, Secuencia $secuencia)
    {        
        return $secuencia->buscar( $keyValues, $this );
    }

    /**
     * 
     * @param type $keyValues
     * @param \Pronit\CoreBundle\Entity\Automatizacion\Secuencias\TablaCondicion $tablaCondicion
     * @return \Pronit\CoreBundle\Entity\Automatizacion\Secuencias\RegistroCondicion | null
     */
    public function buscarPorTablaCondicion( $keyValues, TablaCondicion $tablaCondicion)
    {
        $qbCondiciones = $this->em->createQueryBuilder();
        $i=1;
        foreach( $keyValues as $metadataName => $metadataValue ){
            $qbCondiciones->orWhere("( rcmv.metadataName='{$metadataName}' AND rcmv.value = ?{$i} )");
            $i++;
        }
        
        $qb2 = $this->em->createQueryBuilder()
                    ->select( 'subrc.id' )
                    ->from('Pronit\CoreBundle\Entity\Automatizacion\Secuencias\RegistroCondicionMetadataValue','rcmv')
                    ->join('rcmv.registroCondicion','subrc')
                    ->join('subrc.tablaCondicion','subt')
                    ->where('subt.id = ' . $tablaCondicion->getId())
                    ->andWhere( $qbCondiciones->getDQLPart('where') )
                    ->groupBy('rcmv.registroCondicion')
                    ->having('count(rcmv.id) = ' . count( $keyValues ));        

        $qb = $this->em->createQueryBuilder();        
        $qb->select('rc')
            ->from('Pronit\CoreBundle\Entity\Automatizacion\Secuencias\RegistroCondicion','rc')
            ->andWhere(
                $qb->expr()->in(  'rc.id', $qb2->getDql() )
            );

        /* Resta asignar los valores de los metadatos al query */
                
        /* @var $registroCondicionMetadataProvider \Bluegrass\Metadata\Bundle\MetadataBundle\Model\MetadataProvider\IMetadataProvider */
        $registroCondicionMetadataProvider = $this->metadataProviderFactory->getMetadataProviderFor($tablaCondicion->getTableMetadata()); 
        
        $i=1;
        foreach( $keyValues as $metadataName => $value ){
            
            if( $registroCondicionMetadataProvider->hasMetadata($metadataName) ){
                /* @var $metadata \Bluegrass\Metadata\Bundle\MetadataBundle\Model\Metadata */
                $metadata = $registroCondicionMetadataProvider->getMetadata($metadataName);

                $qb->setParameter($i, $metadata->normalizeValue($value));
                $i++;                
            }else{
                throw new \Exception("La tabla de condición no tiene definido el atributo de búsqueda '$metadataName'");
            }
        }
        
        $result = $qb->getQuery()->getOneOrNullResult();
        return $result;
    }
    
}
