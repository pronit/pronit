<?php
namespace Pronit\GestionBienesYServiciosBundle\Admin\Customizing\EstructuraEmpresa;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
/**
 *
 * @author ldelia
 */
class BienServicioSociedadFIAdmin extends Admin
{
 // Fields to be shown on create/edit forms
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('sociedadFI')
            ->add('bienServicio')                
            ->add('codigo')                                                
            ->add('precioValoracionPromedio')
            ->add('precioValoracionEstandar')
        ;
    }

    // Fields to be shown on filter forms
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('sociedadFI')
            ->add('bienServicio')
        ;
    }

    // Fields to be shown on lists
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('sociedadFI')
            ->addIdentifier('bienServicio')                
            ->add('codigo')                                                
            ->add('precioValoracionPromedio')
            ->add('precioValoracionEstandar')
            ->add('_action', 'actions', array(
                    'actions' => array(
                        'show' => array(),
                    ),                
                )
            )
                
        ;
    }
    
    protected function configureShowFields(ShowMapper $showMapper)
    {
        // Here we set the fields of the ShowMapper variable, $showMapper (but this can be called anything)
        $showMapper
            ->add('sociedadFI')
            ->add('bienServicio')                
            ->add('codigo')                                                
            ->add('precioValoracionPromedio')
            ->add('precioValoracionEstandar')
        ;

    }    
}


