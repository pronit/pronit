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
        $tipos = array( 
                'pais' => 'País', 
                'distritofederal' => 'Distrito Federal', 
                'comunidadautonoma' => 'Comunidad Autonoma', 
                'provincia' => 'Provincia', 
                'partido' => 'Partido', 
                'ciudad' => 'Ciudad', 
                'barrio' => 'Barrio',

                'departamento' => 'Departamento',             
                'pedania' => 'Pedanía' // En Córdoba Argentina
            );
        
        foreach( $tipos as $clave => $valor )
        {
            $tipo = new TipoDivisionAdministrativa();
            $tipo->setNombre($valor);
            
            $manager->persist($tipo);       
            
            $this->addReference('pronit-geographic-tipodivisionadministrativa-' . $clave, $tipo);
        }                    

        $manager->flush();
    }

    function getOrder()
    {
        return 20; 
    }
}
