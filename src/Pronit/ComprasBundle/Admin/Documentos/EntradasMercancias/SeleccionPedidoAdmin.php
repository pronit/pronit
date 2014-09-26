<?php
namespace Pronit\ComprasBundle\Admin\Documentos\EntradasMercancias;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\AdminBundle\Route\RouteCollection;
/**
 *
 * @author ldelia
 */
class SeleccionPedidoAdmin extends Admin
{   
    protected $baseRouteName = 'pronit_entradas_mercancias_seleccion_pedido';
    protected $baseRoutePattern = 'entradas-mercancias-desde-pedido';
    
    // Fields to be shown on lists
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('numero',null, array(
                'route' => array('name' => 'show')
            ))
            ->add('estado')
            ->add('sociedad')
            ->add('fecha', 'date', array( 'format' => 'd/m/Y' ))
            ->add('proveedorSociedad', null, array('label'=>'Proveedor') ) 
            ->add('centroLogistico')
            ->add('moneda')
            ->add('_action', 'actions', array(
                    'actions' => array(
                        'crearEntradaMercanciaDesdePedido' => array(
                            'template' => 'PronitComprasBundle:Documentos\EntradasMercancias\list:crearEntradasMercanciaDesdePedidoAction.html.twig'
                        ),
                    ),                
                )
            )                
        ;
    }

    protected function configureShowFields(ShowMapper $showMapper)
    {
        // Here we set the fields of the ShowMapper variable, $showMapper (but this can be called anything)
        $showMapper
            ->with('Cabecera')
                ->add('numero')
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
            ->add('proveedorSociedad', null, array('label'=>'Proveedor') )  
            ->add('centroLogistico')
            ->add('textoCabecera')
        ;
    }
    
    protected function configureRoutes(RouteCollection $collection)
    {
        $collection->clearExcept(array('list', 'show'));
        
        $collection->add('crearEntradaMercanciasDesdePedido', $this->getRouterIdParameter() . '/new');
    }    
}