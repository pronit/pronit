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
class ConversionSistemaMedicionAdmin extends Admin
{
 // Fields to be shown on create/edit forms
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('desde', 'sonata_type_model', array('label' => 'Sistema Medición Desde', 'property' => 'nombre'))
            ->add('hasta', 'sonata_type_model', array('label' => 'Sistema Medición Hasta', 'property' => 'nombre'))
            ->add('factor', 'number', array('label' => 'Factor'))
        ;
    }

    // Fields to be shown on lists
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('desde')
            ->add('hasta')
            ->add('factor')
        ;
    }
}


