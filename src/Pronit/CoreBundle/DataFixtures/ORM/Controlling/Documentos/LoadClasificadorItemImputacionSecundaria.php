<?php

namespace Pronit\CoreBundle\DataFixtures\ORM\Controlling\Documentos;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Pronit\CoreBundle\Entity\Controlling\Documentos\ClasificadorItemImputacionSecundaria;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * @author ldelia
 */
class LoadClasificadorItemImputacionSecundaria extends AbstractFixture implements FixtureInterface, OrderedFixtureInterface, ContainerAwareInterface {

    /**
     * @var ContainerInterface
     */
    private $container;
    private $manager;

    /**
     * {@inheritDoc}
     */
    public function setContainer(ContainerInterface $container = null) {
        $this->container = $container;
    }

    public function getManager() {
        return $this->manager;
    }

    public function setManager(ObjectManager $manager) {
        $this->manager = $manager;
    }

    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager) {
        $this->setManager($manager);

        $values = array(
            array("codigo" => "1", "nombre" => "Item emisor"),
            array("codigo" => "2", "nombre" => "Item receptor")
        );

        foreach ($values as $value) {
            $obj = new ClasificadorItemImputacionSecundaria();
            $obj->setCodigo($value['codigo']);
            $obj->setNombre($value['nombre']);

            $manager->persist($obj);

            $this->addReference('pronit-documentos-clasificadoritemimputacionsecundaria-' . $value['codigo'], $obj);
        }

        $manager->flush();
    }

    function getOrder() {
        return 14;
    }

}
