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
class CentroLogisticoAdmin extends Admin
{
     // Fields to be shown on create/edit forms
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('sociedadFI')                
            ->add('codigo')
            ->add('nombre')
            ->add('divisionAdministrativa')
            ->with('Almacenes')
                ->add('almacenes', 'sonata_type_collection', array('cascade_validation' => true, 'by_reference' => false), array(
                    'edit' => 'inline',
                    'inline' => 'table',                    
                ))
            ->end()  
        ;
    }
    // Fields to be shown on filter forms
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('codigo')
            ->add('nombre')                
            ->add('sociedadFI')                                
        ;
    }

    // Fields to be shown on lists
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('sociedadFI')                
            ->add('codigo')
            ->add('nombre')
            ->add('divisionAdministrativa')
            ->add('_action', 'actions', array(
                    'actions' => array(
                        'edit' => array(),
                    ),                
                )
            )
                
        ;
    }
}


