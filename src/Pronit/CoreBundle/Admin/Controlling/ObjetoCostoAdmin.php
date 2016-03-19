<?php
namespace Pronit\CoreBundle\Admin\Controlling;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;

abstract class ObjetoCostoAdmin extends Admin
{
 // Fields to be shown on create/edit forms
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('nombre', 'text', array('label' => 'Nombre'))
            ->add('sociedadFI')
            ->add('cuentaContable')
            ->add('validezDesde', 'date', array('widget' => 'single_text'))
            ->add('validezHasta', 'date', array('widget' => 'single_text'))
        ;
    }

    // Fields to be shown on filter forms
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('nombre')
            ->add('sociedadFI')
            ->add('cuentaContable')
            ->add('validezDesde')
            ->add('validezHasta')                
        ;
    }

    // Fields to be shown on lists
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('nombre')
            ->add('sociedadFI')
            ->add('cuentaContable')
            ->add('validezDesde', 'date', array( 'format' => 'd/m/Y' ))
            ->add('validezHasta', 'date', array( 'format' => 'd/m/Y' ))                
            ->add('importe', 'currency', array(
                'template' => 'PronitCoreBundle:Controlling/ObjetoCosto:list_importe.html.twig'
            ))
        ;
    }
}


