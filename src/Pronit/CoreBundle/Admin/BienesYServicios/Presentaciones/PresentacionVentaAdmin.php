<?php
namespace Pronit\CoreBundle\Admin\BienesYServicios\Presentaciones;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;

/**
 *
 * @author ldelia
 */
class PresentacionVentaAdmin extends Admin
{
    protected $parentAssociationMapping = 'material';
    
     // Fields to be shown on create/edit forms
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('nombre')
            ->add('unidades')                
            ->add('fraccionamientoVentaDestino', 'sonata_type_admin')
        ;
        
    }

    // Fields to be shown on lists
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('nombre')                
            ->add('escalas')                
        ;
    }
}


