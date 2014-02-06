<?php
namespace Pronit\ParametrizacionGeneralBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;

/**
 *
 * @author ldelia
 */
class PeriodoVarianteEjercicioAdmin extends Admin
{
    
 // Fields to be shown on create/edit forms
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('nombre', 'text', array('label' => 'Nombre', 'max_length' => 15))
            ->add('abreviatura', 'text', array('label' => 'Abreviatura', 'max_length' => 3))
            ->add('mes', 'integer')
            ->add('periodo', 'integer')    
            ->add('diaComienzo', 'integer')    
            ->add('mesComienzo', 'integer')    
            ->add('diaFin', 'integer')    
            ->add('mesFin', 'integer')        
        ;
    }

    // Fields to be shown on filter forms
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('nombre')
            ->add('abreviatura')    
        ;
    }

    // Fields to be shown on lists
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('nombre')
            ->add('abreviatura')
        ;
    }
}


