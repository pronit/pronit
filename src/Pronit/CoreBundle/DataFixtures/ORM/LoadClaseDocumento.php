<?php

namespace Pronit\CoreBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Pronit\CoreBundle\Entity\Documentos\ClaseDocumento;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * @author gcaseres
 */
class LoadClaseDocumento extends AbstractFixture implements FixtureInterface, OrderedFixtureInterface, ContainerAwareInterface {

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
            array("codigo" => ClaseDocumento::CODIGO_PEDIDO, "nombre" => "Pedido de compras"),
            array("codigo" => ClaseDocumento::CODIGO_FACTURAACREEDOR, "nombre" => "Factura de acreedor"),
            array("codigo" => ClaseDocumento::CODIGO_ENTRADAMERCANCIAS, "nombre" => "Entrada de mercancías"),
            array("codigo" => ClaseDocumento::CODIGO_PEDIDOVENTA, "nombre" => "Pedido de ventas"),
            array("codigo" => ClaseDocumento::CODIGO_FACTURADEUDOR, "nombre" => "Factura de deudor"),
            array("codigo" => ClaseDocumento::CODIGO_SALIDAMERCANCIAS, "nombre" => "Salida de mercancías"),            
        );

        foreach ($values as $value) {

            $obj = new ClaseDocumento($value['codigo'], $value['nombre']);

            $manager->persist($obj);

            $this->addReference('pronit-core-clasedocumento-' . $value["codigo"], $obj);
        }

        $manager->flush();
    }

    function getOrder() {
        return 10;
    }

}
