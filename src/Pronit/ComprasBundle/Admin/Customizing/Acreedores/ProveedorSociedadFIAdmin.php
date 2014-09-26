<?php
namespace Pronit\ComprasBundle\Admin\Customizing\Acreedores;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

/**
 *
 * @author ldelia
 */
class ProveedorSociedadFIAdmin extends Admin
{
 // Fields to be shown on create/edit forms
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('sociedadFI')
            ->add('acreedor', null, array( 'class' => 'Pronit\CoreBundle\Entity\Personas\Proveedor' ) )
            ->add('codigo')                                                
            ->add('monedaPedido')
        ;
    }

    // Fields to be shown on filter forms
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('sociedadFI')
            ->add('acreedor')                
            ->add('codigo')                                                
            ->add('monedaPedido')        
        ;
    }

    // Fields to be shown on lists
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('sociedadFI')
            ->add('acreedor')                
            ->add('codigo')                                                
            ->add('monedaPedido')
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
            ->add('acreedor')                
            ->add('codigo')                                                
            ->add('monedaPedido')                
        ;

    }    
}


