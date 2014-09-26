<?php
namespace Pronit\CoreBundle\Admin\Personas;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;

/**
 *
 * @author ldelia
 */
class PersonaFisicaAdmin extends Admin
{
 // Fields to be shown on create/edit forms
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('apellido')
            ->add('nombre')
        ;
    }

    // Fields to be shown on filter forms
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('apellido')
            ->add('nombre')
        ;
    }

    // Fields to be shown on lists
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('apellido')                
            ->add('nombre')                
            ->add('_action', 'actions', array(
                    'actions' => array(
                        'edit' => array(),
                    ),                
                )
            )                

        ;
    }
}


