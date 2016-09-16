<?php
namespace Pronit\ParametrizacionGeneralBundle\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin as Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;

/**
 * Description of SociedadFIAdmin
 *
 * @author gcaseres
 */
class MonedaAdmin extends Admin
{
 // Fields to be shown on create/edit forms
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('nombre', 'text', array('label' => 'Nombre'))
            ->add('abreviatura', 'text', array('label' => 'Abreviatura'))
            ->add('signoMonetario', 'text', array('label' => 'Signo monetario'))
            ->add('codigoISO', 'text', array('label' => 'Código I.S.O.', 'max_length' => 3))
        ;
    }

    // Fields to be shown on filter forms
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('nombre')
            ->add('signoMonetario')
            ->add('codigoISO')
        ;
    }

    // Fields to be shown on lists
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('nombre')
            ->add('abreviatura')
            ->add('signoMonetario')
            ->add('codigoISO')
        ;
    }
}


