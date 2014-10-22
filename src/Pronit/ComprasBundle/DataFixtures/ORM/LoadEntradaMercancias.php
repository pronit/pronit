<?php

namespace Pronit\ComprasBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Pronit\ComprasBundle\Entity\Documentos\EntradasMercancias\EntradaMercancias;
use Pronit\ComprasBundle\Entity\Documentos\EntradasMercancias\ItemEntradaMercancias;

/**
 * @author ldelia
 */
class LoadEntradaMercancias extends AbstractFixture implements FixtureInterface, OrderedFixtureInterface, ContainerAwareInterface {

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

        $sociedad = $this->getReference('pronit-estructuraempresa-sociedadfi');
        $moneda = $this->getReference('pronit-parametrizaciongeneral-moneda-pesos');

        $clasificador = $this->getReference('pronit-documentos-clasificadoritementradamercancias-101');        


        $entradaMercancias = new EntradaMercancias();
        $entradaMercancias->setSociedad($sociedad);
        $entradaMercancias->setNumero("0001/1");
        $entradaMercancias->setFecha(new \DateTime());
        $entradaMercancias->setMoneda($moneda);
        $entradaMercancias->setTextoCabecera('Entrada de Mercancias.... ');


        $material = $this->getReference('pronit-gestionbienesyservicios-bienservicio-610615008');
        $item = new ItemEntradaMercancias();
        $item->setClasificador($clasificador);
        $item->setCantidad(100);
        $item->setBienServicio($material);
        $item->setPrecioUnitario(25.5);
        $entradaMercancias->addItem($item);

        $material = $this->getReference('pronit-gestionbienesyservicios-bienservicio-610612011');
        $item = new ItemEntradaMercancias();
        $item->setClasificador($clasificador);
        $item->setCantidad(2500);
        $item->setBienServicio($material);
        $item->setPrecioUnitario(3.825);
        $entradaMercancias->addItem($item);
        
        $manager->persist($entradaMercancias);

        $manager->flush();
    }

    function getOrder() {
        return 82;
    }

}
