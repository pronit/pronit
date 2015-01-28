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

        $pedidoEntregado = $this->getReference('pronit-compras-pedido-3444/5');

        $entradaMercancias = new EntradaMercancias();
        $entradaMercancias->setSociedad($sociedad);
        $entradaMercancias->setNumero("0001/1");
        $entradaMercancias->setFecha(new \DateTime());
        $entradaMercancias->setMoneda($moneda);
        $entradaMercancias->setCentroLogistico( $pedidoEntregado->getCentroLogistico() );
        $entradaMercancias->setProveedorSociedad( $pedidoEntregado->getProveedorSociedad() );
        $entradaMercancias->setTextoCabecera('Entrada de Mercancias desde pedido. ');

        foreach( $pedidoEntregado->getItems() as $itemPedido  ){
            
            $item = new ItemEntradaMercancias();
            $item->setClasificador($clasificador);
            $item->setCantidad( $itemPedido->getCantidad() );
            $item->setEscala( $itemPedido->getEscala() );
            $item->setBienServicio( $itemPedido->getBienServicio() );
            $item->setPrecioUnitario($itemPedido->getPrecioUnitario());
            $item->setItemPedidoEntregado( $itemPedido );
            
            $entradaMercancias->addItem($item);
        }                
                
        $manager->persist($entradaMercancias);

        /* @var $transaccionEntradaMercancias \Pronit\ComprasBundle\Model\Transacciones\EntradasMercancias\TransaccionEntradaMercancias  */
        $transaccionEntradaMercancias = $this->container->get('pronit_compras_transaccion.entradamercancias');
        $transaccionEntradaMercancias->ejecutar($entradaMercancias);        

        $manager->flush();
    }

    function getOrder() {
        return 82;
    }

}
