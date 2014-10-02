<?php
namespace Pronit\ComprasBundle\Admin\Documentos\EntradasMercancias;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Route\RouteCollection;

use Pronit\ComprasBundle\Entity\Documentos\EntradasMercancias\EntradaMercancias;
use Pronit\ComprasBundle\Entity\Documentos\EntradasMercancias\ItemEntradaMercancias;

/**
 *
 * @author ldelia
 */
class EntradaMercanciasAdmin extends Admin
{   
    protected $baseRouteName = 'pronit_entradas_mercancias';
    
    // Fields to be shown on lists
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('numero')
            ->add('estado')
            ->add('sociedad')
            ->add('fecha', 'date', array( 'format' => 'd/m/Y' ))
            ->add('proveedorSociedad', null, array('label'=>'Proveedor') ) 
            ->add('centroLogistico')
            ->add('moneda')
            ->add('_action', 'actions', array(
                    'actions' => array(
                        'show' => array(),
                        'edit' => array(),
                    ),                
                )
            )                
        ;
    }
    
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->with('Entrada de Mercancías')
                ->add('numero')
                ->add('sociedad')                
                ->add('fecha', 'date', array('widget' => 'single_text'))                                                
                ->add('proveedorSociedad', null, array('label'=>'Proveedor') )
                ->add('centroLogistico')
                ->add('moneda')
                ->add('textoCabecera')
            ->end()
            ->with('Items')
                ->add('items', 
                    'sonata_type_collection', 
                    array(
                        'cascade_validation' => true, 
                        'by_reference' => false, 
                    ), 
                    array(
                        'edit' => 'inline',
                        'inline' => 'table',                    
                        'admin_code' => 'pronit.admin.compras.entradasmercancias.itementradamercancias'
                    )
                )
            ->end()                    
        ; 
    }        
    
    protected function configureRoutes(RouteCollection $collection)
    {
        $collection->clearExcept(array('create' , 'list'));        
    }    
    
    public function getNewInstance()
    {
        $entradaMercancia = new EntradaMercancias();
        
        $pedido_id = $this->request->query->get('pedido_id');
        
        /* 
         * Obtener clasificador item por defecto para EntradaMercancias
         * TODO: Debería definirse como customizing.
         */        
        $clasificadores = $this->getConfigurationPool()->getContainer()->get('doctrine')
                ->getRepository('Pronit\ComprasBundle\Entity\Documentos\EntradasMercancias\ClasificadorItemEntradaMercancias')
                ->createQueryBuilder('q')
                ->setMaxResults(1)
                ->getQuery()->getResult();
        $clasificador = $clasificadores[0];
        
        /* @var $pedido \Pronit\ComprasBundle\Entity\Documentos\Pedidos\Pedido  */
        $pedido = $this->getModelManager()->find('Pronit\ComprasBundle\Entity\Documentos\Pedidos\Pedido', $pedido_id);        
        
        if( $pedido ){
            
            $entradaMercancia->setSociedad( $pedido->getSociedad() );
            $entradaMercancia->setMoneda( $pedido->getMoneda() );
            $entradaMercancia->setCentroLogistico( $pedido->getCentroLogistico() );
            $entradaMercancia->setProveedorSociedad( $pedido->getProveedorSociedad() );

            foreach ( $pedido->getItems() as $itemPedido ) 
            {
                /* @var $itemPedido \Pronit\ComprasBundle\Entity\Documentos\Pedidos\ItemPedido  */

                $item = new ItemEntradaMercancias();
                $item->setClasificador($clasificador);       
                $item->setBienServicio($itemPedido->getBienServicio());
                $item->setPrecioUnitario($itemPedido->getPrecioUnitario());
                $item->setCantidad($itemPedido->getCantidad());        
                $item->setEscala($itemPedido->getEscala());

                $entradaMercancia->addItem($item);
            }
        }
        return $entradaMercancia;
    }
}