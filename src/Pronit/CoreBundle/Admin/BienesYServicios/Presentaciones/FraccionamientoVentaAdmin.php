<?php
namespace Pronit\CoreBundle\Admin\BienesYServicios\Presentaciones;

use Sonata\AdminBundle\Admin\AbstractAdmin as Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;

/**
 *
 * @author ldelia
 */
class FraccionamientoVentaAdmin extends Admin
{
     // Fields to be shown on create/edit forms
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('cantidad')                
            ->add('unidad')
            ->add('presentacionDestino')
        ;        
    }        
}


