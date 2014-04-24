<?php

namespace Pronit\Geographic\CoreBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;

use Pronit\Geographic\CoreBundle\Entity\TipoDivisionAdministrativa;

/**
 * @author ldelia
 */
class LoadTipoDivisionesAdministrativas extends AbstractFixture implements FixtureInterface , OrderedFixtureInterface
{
    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        $tipos = array( 'País', 'Distrito Federal', 'Comunidad Autonoma', 'Provincia', 'Partido', 'Ciudad', 'Barrio' );
        
        foreach( $tipos as $t )
        {
            $tipo = new TipoDivisionAdministrativa($t);
            $manager->persist($tipo);       
            
            $this->addReference('pronit-geographic-tipodivisionadministrativa-' . strtolower( $t ), $tipo);
        }                    

        $manager->flush();
    }

    function getOrder()
    {
        return 1; 
    }
}
