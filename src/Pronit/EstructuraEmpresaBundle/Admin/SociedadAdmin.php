<?php
namespace Pronit\EstructuraEmpresaBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;

/**
 *
 * @author ldelia
 */
abstract class SociedadAdmin extends Admin
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
            ->add('variantesEjercicio', 'sonata_type_collection', 
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
            ->add('_action', 'actions', array(
                        'actions' => array(
                            'edit' => array(),
                            'test' => array('template' => 'PronitEstructuraEmpresaBundle:SociedadFI:list_action_1.html.twig'),                                                        
                        ),
                        'translation_domain' => 'SonataAdminBundle'
                    )                    
            )                
        ;
    }
}


