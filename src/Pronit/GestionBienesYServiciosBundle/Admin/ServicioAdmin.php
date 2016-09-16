<?php
namespace Pronit\GestionBienesYServiciosBundle\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin as Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;

/**
 *
 * @author ldelia
 */
class ServicioAdmin extends Admin
{
 // Fields to be shown on create/edit forms
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('codigo', 'text')
            ->add('nombre')
            ->add('tipo', 'entity', array('class' => 'Pronit\GestionBienesYServiciosBundle\Entity\TipoServicio') )                                                
            ->add('categoriaValoracion')
            ->add('sistemaMedicion')
        ;
    }

    // Fields to be shown on filter forms
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('nombre')
        ;
    }

    // Fields to be shown on lists
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('codigo')
            ->add('nombre')
            ->add('categoriaValoracion')
            ->add('sistemaMedicion')
        ;
    }
}


