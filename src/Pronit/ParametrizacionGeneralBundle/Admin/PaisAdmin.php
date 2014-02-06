<?php
namespace Pronit\ParametrizacionGeneralBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;

/**
 * Description of SociedadFIAdmin
 *
 * @author gcaseres
 */
class PaisAdmin extends Admin
{
 // Fields to be shown on create/edit forms
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('nombre', 'text', array('label' => 'Nombre', 'max_length' => 50))
            ->add('abreviatura', 'text', array('label' => 'Abreviatura', 'max_length' => 10))
            ->add('nombreLargo', 'text', array('label' => 'Nombre largo', 'max_length' => 100))
            ->add('codigoISO', 'text', array('label' => 'Código I.S.O.', 'max_length' => 2))
            ->add('claveAlternativa', 'text', array('label' => 'Clave alternativa', 'max_length' => 10))
            ->add('claveISOExtendida', 'text', array('label' => 'Clave ISO extendida', 'max_length' => 3))
            ->add('longitudCodigoPostal', 'integer', array('label' => 'Longitud de Código Postal'))
            ->add('nacionalidad', 'text', array('label' => 'Nacionalidad', 'max_length' => 50))            
        ;
    }

    // Fields to be shown on filter forms
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('nombre')
            ->add('nombreLargo')
            ->add('abreviatura')    
            ->add('codigoISO')
        ;
    }

    // Fields to be shown on lists
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('nombre')
            ->add('abreviatura')
            ->add('codigoISO')
                 // add custom action links
            ->add('_action', 'actions', array(
                'actions' => array(
                    'edit' => array(),
                )
            ))
        ;
    }
}


