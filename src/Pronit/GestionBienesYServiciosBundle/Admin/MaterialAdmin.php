<?php
namespace Pronit\GestionBienesYServiciosBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;

/**
 *
 * @author ldelia
 */
class MaterialAdmin extends Admin
{
 // Fields to be shown on create/edit forms
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->with('Material', array('class' => 'col-md-6'))->end()
            ->with('Presentaciones de Compra', array('class' => 'col-md-6'))->end()
            ->with('Presentaciones de Venta', array('class' => 'col-md-6') )->end()
        ;   
        
        $formMapper
            ->with('Material')
                    ->add('codigo', 'text')
                    ->add('nombre')
                    ->add('tipo', 'entity', array('class' => 'Pronit\GestionBienesYServiciosBundle\Entity\TipoMaterial') )                
                    ->add('categoriaValoracion')
                    ->add('sistemaMedicion')
            ->end()
            ->with('Presentaciones de Compra')
                ->add('presentacionesCompra', 
                    'sonata_type_collection', 
                    array(
                        'cascade_validation' => true, 
                        'by_reference' => false, 
                    ), 
                    array(
                        'edit' => 'inline',
                        'inline' => 'table',                    
                        'admin_code' => 'pronit.admin.core.bienesyservicios.presentaciones.presentacioncompra'
                    )
                )                
            ->end()        
            ->with('Presentaciones de Venta')
                ->add('presentacionesVenta', 
                    'sonata_type_collection', 
                    array(
                        'cascade_validation' => true, 
                        'by_reference' => false, 
                    ), 
                    array(
                        'edit' => 'inline',
                        'inline' => 'table',                    
                        'admin_code' => 'pronit.admin.core.bienesyservicios.presentaciones.presentacionventa'
                    )
                )                
            ->end()        
                
        ;
    }

    // Fields to be shown on filter forms
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('nombre')
            ->add('tipo')
        ;
    }

    // Fields to be shown on lists
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('codigo')
            ->add('nombre')
            ->add('tipo')                                
            ->add('categoriaValoracion')
            ->add('sistemaMedicion')
        ;
    }
}


