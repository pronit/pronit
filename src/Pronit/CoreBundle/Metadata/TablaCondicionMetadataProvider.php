<?php

namespace Pronit\CoreBundle\Metadata;

use Doctrine\ORM\EntityManager;

use Bluegrass\Metadata\Bundle\MetadataBundle\Model\MetadataProvider\EntityTableMetadataProvider;

use Pronit\CoreBundle\Metadata\TablaCondicionMetadataValueFactory;

/**
 *
 * @author ldelia
 */
class TablaCondicionMetadataProvider extends EntityTableMetadataProvider
{
    public function __construct(EntityManager $em)
    {        
        parent::__construct($em);
        
        $this->setMetadataValueFactory( new TablaCondicionMetadataValueFactory() );
    }

    public function getEntityType()
    {
        return '\Pronit\CoreBundle\Entity\Automatizacion\Secuencias\TablaCondicion';
    }    
}