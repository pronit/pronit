<?php

namespace Pronit\CustomizingBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Pronit\CustomizingBundle\Entity\Operaciones\MappingClasificadorItemOperacion;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * @author gcaseres
 */
class LoadMappingClasificadorItemFacturaOperacion extends AbstractFixture implements FixtureInterface, OrderedFixtureInterface, ContainerAwareInterface {

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
            array("codigo" => "102", "operacion" => "WRZ", "funcion" => "DOC_EM_ITEM_IMPORTENETO"),
        );

        foreach ($values as $value) {

            $clasificador = $this->getReference('pronit-documentos-clasificadoritemfactura-' . $value['codigo']);
            $operacion = $this->getReference('pronit-core-operacion-' . $value['operacion']);
            $funcion = $this->getReference('pronit-automatizacion-funcion-' . $value['funcion']);
            
            $obj = new MappingClasificadorItemOperacion();
            $obj->setClasificador($clasificador);
            $obj->setOperacion($operacion);
            $obj->setFuncion($funcion);
            
            $this->setReference('pronit-customizing-mappingclasificadoritemoperacion-' . $value['codigo'] . $value['operacion'], $obj);

            $manager->persist($obj);
        }

        $manager->flush();
    }

    function getOrder() {
        return 61;
    }

}
