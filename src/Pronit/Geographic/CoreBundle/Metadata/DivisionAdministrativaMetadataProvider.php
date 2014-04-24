<?php

namespace Pronit\Geographic\CoreBundle\Metadata;

use Doctrine\ORM\EntityManager;

use Bluegrass\Metadata\Bundle\MetadataBundle\Model\MetadataProvider\EntityTableMetadataProvider;

use Pronit\Geographic\CoreBundle\Metadata\DivisionAdministrativaMetadataValueFactory;

/**
 * Proveedor de Metadatos para Divisiones Administrativas
 *
 * @author ldelia
 */
class DivisionAdministrativaMetadataProvider extends EntityTableMetadataProvider
{
    public function __construct(EntityManager $em)
    {        
        parent::__construct($em);
        
        $this->setMetadataValueFactory( new DivisionAdministrativaMetadataValueFactory() );
    }

    public function getEntityType()
    {
        return '\Pronit\Geographic\CoreBundle\Entity\DivisionAdministrativa';
    }    
}