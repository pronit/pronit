<?php

namespace Pronit\CustomizingBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Pronit\CoreBundle\Entity\Documentos\ClaseDocumento;
use Pronit\CustomizingBundle\Entity\Operaciones\AsociacionOperacionClaseDocumento;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * @author gcaseres
 */
class LoadAsociacionOperacionClaseDocumentoFactura extends AbstractFixture implements FixtureInterface, OrderedFixtureInterface, ContainerAwareInterface {

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
            array("clase" => ClaseDocumento::CODIGO_FACTURAACREEDOR, "operacion" => "KBS"),            
        );

        foreach ($values as $value) {

            $claseDocumento = $this->getReference('pronit-core-clasedocumento-' . $value['clase']);
            $operacion = $this->getReference('pronit-core-operacion-' . $value['operacion']);

            $obj = new AsociacionOperacionClaseDocumento();
            $obj->setClaseDocumento($claseDocumento);
            $obj->setOperacion($operacion);

            $this->setReference('pronit-customizing-asociacionoperacionclasedocumento-' . $value['clase'] . $value['operacion'], $obj);

            $manager->persist($obj);
        }

        $manager->flush();
    }

    function getOrder() {
        return 62;
    }

}
