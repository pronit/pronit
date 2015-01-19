<?php
namespace Pronit\ComprasBundle\Admin\Documentos\Facturas;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;

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
            ->add('bienServicio')
            ->add('escala')                
            ->add('cantidad')
            ->add('precioUnitario')
            ->add('indicadorImpuestos', null, array('required' => true))
            ->add('itemEntradaMercanciasFacturado','sonata_type_model_hidden', array('attr'=> array( 'hidden' => 'true')) )
        ;
        
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


