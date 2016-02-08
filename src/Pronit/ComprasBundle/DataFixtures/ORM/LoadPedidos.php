<?php

namespace Pronit\ComprasBundle\DataFixtures\ORM;

use DateTime;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Pronit\ComprasBundle\Entity\Documentos\Pedidos\ItemPedido;
use Pronit\ComprasBundle\Entity\Documentos\Pedidos\Pedido;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * @author ldelia
 */
class LoadPedidos extends AbstractFixture implements FixtureInterface, OrderedFixtureInterface, ContainerAwareInterface {

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

        $sociedad = $this->getReference('pronit-estructuraempresa-sociedadfi-modelosa');
        $moneda = $this->getReference('pronit-parametrizaciongeneral-moneda-pesos');
        $proveedorSociedad = $this->getReference('pronit-compras-customizing-acreedor-proveedorsociedadfi-delía');
        $centroLogistico = $this->getReference('pronit-estructuraempresa-centroLogistico-3000');

        $clasificador = $this->getReference('pronit-documentos-compras-clasificadoritempedido-100');
        $escalaMetro = $this->getReference('pronit-parametrizaciongeneral-escala-metro');

        
        $pedido = new Pedido();
        $pedido->setSociedad($sociedad);
        $pedido->setNumero("3444/5");
        $pedido->setFecha(new DateTime());
        $pedido->setProveedorSociedad($proveedorSociedad);
        $pedido->setCentroLogistico($centroLogistico);
        $pedido->setMoneda($moneda);
        $pedido->setTextoCabecera('Pedido de compra.... ');

        
        $bienServicio = $this->getReference('pronit-gestionbienesyservicios-bienservicio-610615008');
        $itemPedido = new ItemPedido();
        $itemPedido->setClasificador($clasificador);
        $itemPedido->setCantidad(100);
        $itemPedido->setBienServicio($bienServicio);
        $itemPedido->setPrecioUnitario(25.5);
        $itemPedido->setEscala($escalaMetro);
        $pedido->addItem($itemPedido);

        $bienServicio = $this->getReference('pronit-gestionbienesyservicios-bienservicio-610612011');
        $itemPedido = new ItemPedido();
        $itemPedido->setClasificador($clasificador);
        $itemPedido->setCantidad(2500);
        $itemPedido->setBienServicio($bienServicio);
        $itemPedido->setPrecioUnitario(3.825);
        $itemPedido->setEscala($escalaMetro);
        $pedido->addItem($itemPedido);
        
        $pedido->contabilizar();

        $this->setReference('pronit-compras-pedido-3444/5', $pedido);

        $manager->persist($pedido);

        $manager->flush();
    }

    function getOrder() {
        return 81;
    }

}
