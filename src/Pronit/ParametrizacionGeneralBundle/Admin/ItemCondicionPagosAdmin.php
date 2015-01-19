<?php
namespace Pronit\ParametrizacionGeneralBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;

/**
 *
 * @author gcaseres
 */
class ItemCondicionPagosAdmin extends Admin
{
    
 // Fields to be shown on create/edit forms
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('porcentaje', 'number', array('label' => 'Porcentaje'))
            ->add('cantidadDias', 'text', array('label' => 'Cant. de días'))
        ;
    }

    // Fields to be shown on filter forms
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('porcentaje')
            ->add('cantidadDias')    
        ;
    }

    // Fields to be shown on lists
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('porcentaje')
            ->add('cantidadDias')
        ;
    }
}


