<?php
namespace Pronit\ComprasBundle\Admin\Documentos\Facturas;

use Sonata\AdminBundle\Admin\AbstractAdmin as Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Pronit\ComprasBundle\Form\EventListener\AddEscalaFieldSubscriber;

/**
 *
 * @author gcaseres
 */
class ItemFacturaAdmin extends Admin
{
    protected $parentAssociationMapping = 'documento';
    
     // Fields to be shown on create/edit forms
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('clasificador')
            ->add('presentacionCompra', null, array(
                'refresh_route' => 'update_items_form_field_element'
            ))
            ->add('escala')                
            ->add('cantidad')
            ->add('precioUnitario')
            ->add('indicadorImpuestos', null, array('required' => true))
            ->add('itemEntradaMercanciasFacturado','sonata_type_model_hidden', array('attr'=> array( 'hidden' => 'true')) )
        ;
        $formMapper->getFormBuilder()->addEventSubscriber( new AddEscalaFieldSubscriber($formMapper));
        
    }

    // Fields to be shown on lists
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('bienServicio')                
            ->add('escala')                
            ->add('cantidad')
            ->add('precioUnitario')                
        ;
    }
}


