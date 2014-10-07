<?php
namespace Pronit\ComprasBundle\Admin\Documentos\Pedidos;

use Knp\Menu\ItemInterface as MenuItemInterface;
use Sonata\AdminBundle\Admin\AdminInterface;
use Sonata\AdminBundle\Route\RouteCollection;
use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

use Pronit\ComprasBundle\Entity\Documentos\Pedidos\Pedido;
/**
 *
 * @author ldelia
 */
class PedidoAdmin extends Admin
{
    protected $baseRouteName = 'pronit_pedidos';
    protected $baseRoutePattern = 'pedidos';
            
    // Fields to be shown on lists
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('numero', null, array('route' => array('name' => 'show')))
            ->add('estadoCompras')
            ->add('estado')
            ->add('sociedad')
            ->add('fecha', 'date', array( 'format' => 'd/m/Y' ))
            ->add('proveedorSociedad', null, array('label'=>'Proveedor') ) 
            ->add('centroLogistico')
            ->add('moneda')
        ;
    }

    protected function configureShowFields(ShowMapper $showMapper)
    {
        // Here we set the fields of the ShowMapper variable, $showMapper (but this can be called anything)
        $showMapper
            ->with('Cabecera')
                ->add('numero')
                ->add('estadoCompras')
                ->add('estado')
                ->add('sociedad')                
                ->add('fecha', 'date', array( 'format' => 'd/m/Y' ))                                                
                ->add('proveedorSociedad', null, array('label'=>'Proveedor') )                  
                ->add('centroLogistico')
                ->add('moneda')                
                ->add('textoCabecera')
            ->end()      
            ->with('Items')
                ->add('items', null, array('template' => 'PronitComprasBundle:Documentos\Pedidos\show:items.html.twig'))
            ->end()  

        ;
    }    
    
    // Fields to be shown on filter forms
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('numero')
            ->add('sociedad')                             
            ->add('fecha')
            ->add('estadoCompras')
            ->add('proveedorSociedad', null, array('label'=>'Proveedor') )  
            ->add('centroLogistico')
            ->add('textoCabecera')
        ;
    }

    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->with('Pedido de Compras', array('class' => 'col-md-6'))->end()
            ->with('Cabecera', array('class' => 'col-md-6'))->end()
            ->with('Items', array('class' => 'col-md-12') )->end()
        ;   
        
        $formMapper
            ->with('Pedido de Compras')
                ->add('numero')
                ->add('fecha', 'date', array('widget' => 'single_text'))                                                
                ->add('sociedad')                
            ->end()
            ->with('Cabecera')
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
                        'admin_code' => 'pronit.admin.compras.itempedido'
                    )
                )
            ->end()    
        ; 
    }    
    
    protected function configureSideMenu(MenuItemInterface $menu, $action, AdminInterface $childAdmin = null) 
    {        
        if( $action == "show"){
            
            $admin = $this->isChild() ? $this->getParent() : $this;
            $id = $admin->getRequest()->get('id');

            /* @var $pedido \Pronit\ComprasBundle\Entity\Documentos\Pedidos\Pedido  */            
            $pedido = $this->getObject($id);
            
            if( $pedido->isModificable() ){
                
                $menu->addChild( 'Contabilizar', array('uri' => $admin->generateUrl('contabilizar', array('id' => $id))) )
                        ->setLinkAttribute('class', 'glyphicon glyphicon-ok');            
                
            }         
            
            // Agregar otras condiciones
            if( $pedido->isContabilizado() ){
                $menu->addChild( 'Crear Entrada de Mercancias', array('uri' => $admin->generateUrl('crearEntradaMercanciasDesdePedido', array('id' => $id))) )
                        ->setLinkAttribute('class', 'glyphicon glyphicon-import');                
            }
        }
    }
    
    public function isGranted($name, $pedido = null)
    {
        /* @var $pedido \Pronit\ComprasBundle\Entity\Documentos\Pedidos\Pedido  */
        
        if (( $name == 'EDIT' ) && ( ! is_null($pedido)) ){            
            return $pedido->isModificable() && parent::isGranted($name, $pedido);
        }else{
            return parent::isGranted($name, $pedido);
        }        
    }
    
    protected function configureRoutes(RouteCollection $collection)
    {
        $collection->add('contabilizar', $this->getRouterIdParameter() . '/contabilizar');
        $collection->add('crearEntradaMercanciasDesdePedido', $this->getRouterIdParameter() . '/new');
    }    
}