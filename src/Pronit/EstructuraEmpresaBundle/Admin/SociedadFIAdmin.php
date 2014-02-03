<?php
namespace Pronit\EstructuraEmpresaBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;

/**
 * Description of SociedadFIAdmin
 *
 * @author gcaseres
 */
class SociedadFIAdmin extends Admin
{
 // Fields to be shown on create/edit forms
    protected function configureFormFields(FormMapper $formMapper)
    {
        $today = new \DateTime();
        $years = range(1900, $today->format('Y'));
        
        $formMapper
            ->add('nombre', 'text', array('label' => 'Nombre'))
            ->add('abreviatura', 'text', array('label' => 'Abreviatura'))
            ->add('nombreFantasia', 'text', array('label' => 'Nombre de fantasía'))
            ->add('activa', 'checkbox', array('label' => 'Activa'))
            ->add('fechaFundacion', 'date', array('label' => 'Fecha de fundación', 'years' => $years))
        ;
    }

    // Fields to be shown on filter forms
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('nombre')
            ->add('nombreFantasia')
            ->add('activa')
        ;
    }

    // Fields to be shown on lists
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('nombre')
            ->add('abreviatura')
            ->add('nombreFantasia')
            ->add('activa')
        ;
    }
}


