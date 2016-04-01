<?php
namespace Pronit\CoreBundle\Admin\Documentos\Ventas\Pedidos;

use Knp\Menu\ItemInterface as MenuItemInterface;
use Sonata\AdminBundle\Admin\AdminInterface;
use Sonata\AdminBundle\Route\RouteCollection;
use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

use Pronit\CoreBundle\Entity\Documentos\ClaseDocumento;
use Pronit\CoreBundle\Entity\Documentos\Ventas\Pedidos\Pedido;
/**
 *
 * @author ldelia
 */
class PedidoAdmin extends Admin
{
    protected $baseRouteName = 'pronit_ventas_pedidos';
    protected $baseRoutePattern = 'pedidos-de-venta';
            
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('numero', null, array('route' => array('name' => 'show')))
            ->add('estadoVentas')
            ->add('estadoEntrega')                
            ->add('estadoFacturacion')
            ->add('sociedad')
            ->add('fecha', 'date', array( 'format' => 'd/m/Y' ))
            ->add('deudorSociedad', null, array('label'=>'Cliente') ) 
            ->add('centroLogistico')
            ->add('moneda')
        ;
    }

    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->with('Cabecera')
                ->add('numero')
                ->add('estadoVentas')
                ->add('estadoEntrega')
                ->add('estadoFacturacion')
                ->add('sociedad')                
                ->add('fecha', 'date', array( 'format' => 'd/m/Y' ))                                                
                ->add('deudorSociedad', null, array('label'=>'Cliente') )                  
                ->add('centroLogistico')
                ->add('moneda')                
                ->add('textoCabecera')
            ->end()      
            ->with('Items')
                ->add('items', null, array('template' => 'PronitCoreBundle:Documentos\Ventas\Pedidos\show:items.html.twig'))
            ->end()  

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

    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->with('Pedido de Ventas', array('class' => 'col-md-6'))->end()
            ->with('Cabecera', array('class' => 'col-md-6'))->end()
            ->with('Items', array('class' => 'col-md-12') )->end()
        ;   
        
        $formMapper
            ->with('Pedido de Ventas')
                ->add('numero')
                ->add('fecha', 'date', array('widget' => 'single_text'))                                                
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
                        'admin_code' => 'pronit.admin.core.ventas.itempedido'
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

            /* @var $pedido \Pronit\CoreBundle\Entity\Documentos\Ventas\Pedidos\Pedido  */            
            $pedido = $this->getObject($id);
            
            if( $pedido->isModificable() ){
                
                $menu->addChild( 'Contabilizar', array('uri' => $admin->generateUrl('contabilizar', array('id' => $id))) )
                        ->setLinkAttribute('class', 'glyphicon glyphicon-ok');            
                
            }else{
                
                if(! $pedido->isEntregaFinalizada() ){
                    $menu->addChild( 'Crear Salida de Mercancias', array('uri' => $admin->generateUrl('crearSalidaMercanciasDesdePedido', array('id' => $id))) )
                            ->setLinkAttribute('class', 'glyphicon glyphicon-import');                
                }                
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
        $collection->add('crearSalidaMercanciasDesdePedido', $this->getRouterIdParameter() . '/new');
    }    
    
    public function getNewInstance()
    {
        /* @var $clase \Pronit\CoreBundle\Entity\Documentos\ClaseDocumento  */
        $clase = $this->getModelManager()->find('Pronit\CoreBundle\Entity\Documentos\ClaseDocumento', ClaseDocumento::CODIGO_PEDIDOVENTA);                        
        
        $documento = new Pedido();
        $documento->setClase($clase);
                
        return $documento;
    }    
}