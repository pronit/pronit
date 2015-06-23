<?php
namespace Pronit\CoreBundle\Admin\Documentos\Ventas\SalidasMercancias;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Knp\Menu\ItemInterface as MenuItemInterface;
use Sonata\AdminBundle\Admin\AdminInterface;
use Sonata\AdminBundle\Route\RouteCollection;
use Sonata\AdminBundle\Show\ShowMapper;

use Pronit\CoreBundle\Entity\Documentos\Ventas\SalidasMercancias\SalidaMercancias;
use Pronit\CoreBundle\Entity\Documentos\Ventas\SalidasMercancias\ItemSalidaMercancias;

/**
 *
 * @author ldelia
 */
class SalidaMercanciasAdmin extends Admin
{   
    protected $baseRouteName = 'pronit_ventas_salidas_mercancias';
    
    // Fields to be shown on lists
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('numero', null, array('route' => array('name' => 'show')))
            ->add('estadoVentas')
            ->add('estadoFacturacion')
            ->add('sociedad')
            ->add('fecha', 'date', array( 'format' => 'd/m/Y' ))
            ->add('deudorSociedad', null, array('label'=>'Cliente') ) 
            ->add('centroLogistico')
            ->add('moneda')
        ;
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('numero')
            ->add('sociedad')                             
            ->add('fecha')
            ->add('deudorSociedad', null, array('label'=>'Cliente') )  
            ->add('centroLogistico')
            ->add('textoCabecera')
        ;
    }
    
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->with('Cabecera')
                ->add('numero')
                ->add('estadoVentas')
                ->add('estadoFacturacion')                
                ->add('sociedad')                
                ->add('fecha', 'date', array( 'format' => 'd/m/Y' ))                                                
                ->add('deudorSociedad', null, array( 'label' => 'Cliente' ) )
                ->add('centroLogistico')
                ->add('moneda')                
                ->add('textoCabecera')
            ->end()      
            ->with('Items')
                ->add('items', null, array('template' => 'PronitCoreBundle:Documentos\Ventas\SalidasMercancias\show:items.html.twig'))
            ->end()  

        ;
    }        
    
    protected function configureFormFields(FormMapper $formMapper)
    {
        $pedido_id = $this->request->query->get('pedido_id');

        $formMapper
            ->with('Salida de Mercancías', array('class' => 'col-md-6'))->end()
            ->with('Cabecera', array('class' => 'col-md-6'))->end()
            ->with('Items', array('class' => 'col-md-12') )->end()
        ;   
        
        $formMapper
            ->with('Salida de Mercancías')
                ->add('numero')
                ->add('fecha', 'date', array('widget' => 'single_text'))                                                
                ->add('pedido_id', 'hidden', array('data' => $pedido_id, 'mapped' => false)) 
                ->add('sociedad')                
            ->end()    
            ->with('Cabecera')
                ->add('deudorSociedad', null, array('label'=>'Cliente') )
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
                        'admin_code' => 'pronit.admin.core.ventas.itementradamercancias'
                    )
                )
            ->end()                    
        ; 
    }        
    
    public function getNewInstance()
    {
        $salidaMercancias = new SalidaMercancias();
        
        $pedido_id = $this->request->query->get('pedido_id');
        
        /* @var $pedido \Pronit\CoreBundle\Entity\Documentos\Ventas\Pedidos\Pedido  */
        $pedido = $this->getModelManager()->find('Pronit\CoreBundle\Entity\Documentos\Ventas\Pedidos\Pedido', $pedido_id);        
        
        if( $pedido ){
            
            /* 
             * Obtener clasificador item por defecto para EntradaMercancias
             * TODO: Debería definirse como customizing.
             */        
            $clasificadores = $this->getConfigurationPool()->getContainer()->get('doctrine')
                    ->getRepository('Pronit\CoreBundle\Entity\Documentos\Ventas\SalidasMercancias\ClasificadorItemSalidaMercancias')
                    ->createQueryBuilder('q')
                    ->setMaxResults(1)
                    ->getQuery()->getResult();
            $clasificador = $clasificadores[0];
            
            
            $salidaMercancias->setSociedad( $pedido->getSociedad() );
            $salidaMercancias->setMoneda( $pedido->getMoneda() );
            $salidaMercancias->setCentroLogistico( $pedido->getCentroLogistico() );
            $salidaMercancias->setDeudorSociedad( $pedido->getDeudorSociedad() );

            foreach ( $pedido->getItems() as $itemPedido ) 
            {
                /* @var $itemPedido \Pronit\CoreBundle\Entity\Documentos\Ventas\Pedidos\ItemPedido  */

                $item = new ItemSalidaMercancias();
                $item->setClasificador($clasificador);       
                $item->setBienServicio($itemPedido->getBienServicio());
                $item->setPrecioUnitario($itemPedido->getPrecioUnitario());
                $item->setCantidad($itemPedido->getCantidadPendienteDeEntrega());        
                $item->setEscala($itemPedido->getEscala());
                $item->setItemPedidoEntregado( $itemPedido );
        
                $salidaMercancias->addItem($item);
            }
        }
        return $salidaMercancias;
    }
    
    protected function configureSideMenu(MenuItemInterface $menu, $action, AdminInterface $childAdmin = null) 
    {        
        if( $action == "show"){
            
            $admin = $this->isChild() ? $this->getParent() : $this;
            $id = $admin->getRequest()->get('id');

            /* @var $salidaMercancias \Pronit\CoreBundle\Entity\Documentos\Ventas\SalidasMercancias\SalidaMercancias  */            
            $salidaMercancias = $this->getObject($id);
            
            if( $salidaMercancias->isModificable() ){
                
                $menu->addChild( 'Contabilizar', array('uri' => $admin->generateUrl('contabilizar', array('id' => $id))) )
                        ->setLinkAttribute('class', 'glyphicon glyphicon-ok');                
            }else{
                
                if(! $salidaMercancias->isFacturacionFinalizada() ){
                    $menu->addChild( 'Crear Factura', array('uri' => $admin->generateUrl('crearFacturaDesdeSalidaMercancias', array('id' => $id))) )
                            ->setLinkAttribute('class', 'glyphicon glyphicon-import');                
                }                
            }            
  
        }
    }
    
    public function isGranted($name, $salidaMercancias = null)
    {
        /* @var $salidaMercancias \Pronit\CoreBundle\Entity\Documentos\Ventas\SalidasMercancias\SalidaMercancias  */            
        
        if (( $name == 'EDIT' ) && ( ! is_null($salidaMercancias)) ){            
            return $salidaMercancias->isModificable() && parent::isGranted($name, $salidaMercancias);
        }else{
            return parent::isGranted($name, $salidaMercancias);
        }        
    }
    
    protected function configureRoutes(RouteCollection $collection)
    {
        $collection->add('contabilizar', $this->getRouterIdParameter() . '/contabilizar');
        $collection->add('crearFacturaDesdeSalidaMercancias', $this->getRouterIdParameter() . '/new');
    }        
}
