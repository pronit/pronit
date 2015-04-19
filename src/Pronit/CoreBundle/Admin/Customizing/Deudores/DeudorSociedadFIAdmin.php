<?php
namespace Pronit\CoreBundle\Admin\Customizing\Deudores;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

/**
 *
 * @author ldelia
 */
class DeudorSociedadFIAdmin extends Admin
{
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('sociedadFI')
            ->add('deudor', null, array( 'class' => 'Pronit\CoreBundle\Entity\Personas\Deudor' ) )
            ->add('codigo')                                                
        ;
    }

    // Fields to be shown on filter forms
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('sociedadFI')
            ->add('deudor')                
            ->add('codigo')                                                
        ;
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('sociedadFI')
            ->add('deudor')                
            ->add('codigo')                                                
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
        $showMapper
            ->add('sociedadFI')
            ->add('deudor')                
            ->add('codigo')                                                
        ;

    }    
}


