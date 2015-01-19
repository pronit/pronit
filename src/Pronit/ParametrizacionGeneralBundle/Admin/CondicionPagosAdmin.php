<?php
namespace Pronit\ParametrizacionGeneralBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;

/**
 * 
 *
 * @author gcaseres
 */
class CondicionPagosAdmin extends Admin
{
 // Fields to be shown on create/edit forms
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('codigo', 'text', array('label' => 'Código'))
            ->add('nombre', 'text', array('label' => 'Nombre'))              
            ->add('items', 'sonata_type_collection', 
                array('by_reference' => false),
                array(
                    'edit' => 'inline',
                    'inline' => 'table',
                ))

        ;
    }

    // Fields to be shown on filter forms
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('codigo')
            ->add('nombre')
        ;
    }

    // Fields to be shown on lists
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('codigo')
            ->add('nombre')
            ->add('cantidadPagos', 'number', array('label' => 'Cantidad de pagos'))
        ;
    }
}


