<?php
namespace Pronit\EstructuraEmpresaBundle\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin as Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;

/**
 *
 * @author ldelia
 */
class AlmacenAdmin extends Admin
{
     // Fields to be shown on create/edit forms
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('centroLogistico')                
            ->add('codigo')
            ->add('nombre')
            ->add('divisionAdministrativa')
        ;
    }
    // Fields to be shown on filter forms
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('codigo')
            ->add('nombre')                
            ->add('centroLogistico')                                
        ;
    }

    // Fields to be shown on lists
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('centroLogistico')                
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


