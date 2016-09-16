<?php
namespace Pronit\CoreBundle\Admin\Personas;

use Sonata\AdminBundle\Admin\AbstractAdmin as Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;

/**
 *
 * @author ldelia
 */
class DeudorAdmin extends Admin
{
     protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('persona', null, array('label' => 'Tercero'))
            ->add('cuenta')
        ;
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('persona', null, array('label' => 'Tercero'))
        ;
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('persona', null, array('label' => 'Tercero'))
            ->add('cuenta')
            ->add('_action', 'actions', array(
                    'actions' => array(
                        'edit' => array(),
                    ),                
                )
            )                

        ;
    }
}