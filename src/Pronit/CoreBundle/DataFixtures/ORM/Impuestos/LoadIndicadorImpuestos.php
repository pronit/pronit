<?php

namespace Pronit\CoreBundle\DataFixtures\ORM\Impuestos;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Pronit\CoreBundle\Entity\Impuestos\IndicadorImpuestos;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * @author ldelia
 */
class LoadIndicadorImpuestos extends AbstractFixture implements FixtureInterface, OrderedFixtureInterface, ContainerAwareInterface {

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
    public function load(ObjectManager $manager) 
    {
        $this->setManager($manager);

        $values = array(
            array(
                "codigo" => "C1",
                "nombre" => "IVA Compras 21%",
                "items" => array(
                    array("funcion" => "IMP_AXM", "operacion" => "J1A1", "alicuota" => 21),
                ),
            ),
            array(
                "codigo" => "C2",
                "nombre" => "IVA Compras 21% + Percepciones IIBB BSAS 3,5%",
                "items" => array(
                    array("funcion" => "IMP_AXM", "operacion" => "J1A1", "alicuota" => 21),
                    array("funcion" => "IMP_AXM", "operacion" => "J1B1", "alicuota" => 3.5)
                ),
            ),            
            array(
                "codigo" => "V1",
                "nombre" => "IVA Ventas 21%",
                "items" => array(
                    array("funcion" => "IMP_AXM", "operacion" => "J2A1", "alicuota" => 21)
                ),
            ),            
            
        );

        foreach ($values as $value) {

            $indicadorImpuestos = new IndicadorImpuestos();
            $indicadorImpuestos->setCodigo($value['codigo']);
            $indicadorImpuestos->setNombre($value['nombre']);

            foreach ($value['items'] as $item) {
                $itemIndicadorImpuesto = new \Pronit\CoreBundle\Entity\Impuestos\ItemIndicadorImpuestos();
                $itemIndicadorImpuesto->setOperacionContable( $this->getReference('pronit-core-operacion-' . $item['operacion']) );
                $itemIndicadorImpuesto->setAlicuota( $item['alicuota'] );
                $itemIndicadorImpuesto->setFuncion( $this->getReference('pronit-automatizacion-funcion-' . $item['funcion']) );
                
                $indicadorImpuestos->addItem( $itemIndicadorImpuesto );
            }

            $manager->persist($indicadorImpuestos);

            $this->addReference('pronit-core-indicadorimpuesto-' . $value["codigo"], $indicadorImpuestos);
        }

        $manager->flush();
    }

    function getOrder() {
        return 16;
    }

}
