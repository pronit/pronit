<?php
namespace Pronit\ComprasBundle\Admin\Documentos\Pedidos;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

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

    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->with('Cabecera')
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
                        'admin_code' => 'pronit.admin.compras.itempedido'
                    )
                )
            ->end()    
        ; 
    }    
}