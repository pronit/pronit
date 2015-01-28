<?php

namespace Pronit\CoreBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Pronit\CoreBundle\Entity\Operaciones\OperacionContable;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * @author ldelia
 */
class LoadOperacionContable extends AbstractFixture implements FixtureInterface, OrderedFixtureInterface, ContainerAwareInterface {

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
            array("codigo" => "BSX", "nombre" => "Contabilización de inventario", "claveContabilizacion" => 89),
            array("codigo" => "WRX", "nombre" => "EM/RF abierta", "claveContabilizacion" => 96),
            array("codigo" => "WRZ", "nombre" => "EM/RF concluida", "claveContabilizacion" => 86),
            array("codigo" => "KBS", "nombre" => "Pedido Imputado", "claveContabilizacion" => 31),
            array("codigo" => "PRM", "nombre" => "Dif. de cambio R-", "claveContabilizacion" => 40),
            array("codigo" => "PRG", "nombre" => "Dif. de cambio R+", "claveContabilizacion" => 50),
            array("codigo" => "PRD-", "nombre" => "Dif. de precio negat", "claveContabilizacion" => 83),
            array("codigo" => "PRD+", "nombre" => "Dif. de precio posit", "claveContabilizacion" => 93),
            array("codigo" => "BSD-", "nombre" => "Revalúo inventario en menos", "claveContabilizacion" => 50),
            array("codigo" => "BSD+", "nombre" => "Revalúo inventario en mas", "claveContabilizacion" => 40),
            array("codigo" => "IMP", "nombre" => "Cálculo de impuestos", "claveContabilizacion" => 40),
            array("codigo" => "J1A1", "nombre" => "IVA soportado", "claveContabilizacion" => 40),
        );

        foreach ($values as $value) {

            $obj = new OperacionContable();
            $obj->setCodigo($value['codigo']);
            $obj->setNombre($value['nombre']);
            $obj->setClaveContabilizacion($this->getReference('pronit-core-clavecontabilizacion-' . $value["claveContabilizacion"]));

            $manager->persist($obj);

            $this->addReference('pronit-core-operacion-' . $value['codigo'], $obj);
        }

        $manager->flush();
    }

    function getOrder() {
        return 11;
    }

}
